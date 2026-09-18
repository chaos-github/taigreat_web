<?php

namespace Database\Seeders;

use App\Models\CaseCategory;
use App\Models\CaseItem;
use Illuminate\Database\Seeder;

class CaseSeeder extends Seeder
{
    /**
     * @var list<string>
     */
    private array $featuredTitles = [
        '根基營造 泰山貴和安居 | RC | 台灣新北市',
        '8 Conlay | RC | 馬來西亞 Kuala Lumpur',
        'Cayan Tower | RC | Dubai杜拜',
        '大漢建設 台北我的家 | RC | 台灣台北市',
        '國泰X三井 荷蘭村 | RC |  台灣新竹市',
    ];

    public function run(): void
    {
        $path = database_path('data/cases.json');
        $items = json_decode((string) file_get_contents($path), true) ?? [];

        $categoryIds = [];

        foreach ([
            ['MFE 鋁合金系統模板', 'mfe'],
            ['易塗｜斷熱稀土材料', 'yitu'],
            ['地工科技｜支盤樁', 'pile'],
        ] as $index => [$name, $slug]) {
            $categoryIds[$name] = CaseCategory::query()->updateOrCreate(
                ['slug' => $slug],
                ['name' => $name, 'sort' => $index + 1],
            )->id;
        }

        CaseItem::query()->delete();

        foreach ($items as $index => $item) {
            $categoryId = $categoryIds[$item['category']] ?? null;

            if ($categoryId === null) {
                continue;
            }

            CaseItem::query()->create([
                'case_category_id' => $categoryId,
                'title' => $item['title'],
                'image' => $item['image'],
                'sort' => $index + 1,
                'is_featured' => in_array($item['title'], $this->featuredTitles, true),
            ]);

            $this->downloadImage($item['image']);
        }
    }

    private function downloadImage(string $image): void
    {
        if (app()->environment('testing')) {
            return;
        }

        $filename = basename($image);
        $destination = public_path('assets/taigreat/upload/case/'.$filename);

        if (is_file($destination)) {
            return;
        }

        $directory = dirname($destination);

        if (! is_dir($directory)) {
            mkdir($directory, 0777, true);
        }

        $existing = public_path('assets/taigreat/upload/product/'.$filename);

        if (is_file($existing)) {
            copy($existing, $destination);

            return;
        }

        $contents = @file_get_contents('https://www.taigreat.com.tw/upload/product/'.$filename);

        if ($contents !== false) {
            file_put_contents($destination, $contents);
        }
    }
}
