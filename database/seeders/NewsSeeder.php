<?php

namespace Database\Seeders;

use App\Models\News;
use App\Models\NewsCategory;
use Illuminate\Database\Seeder;

class NewsSeeder extends Seeder
{
    public function run(): void
    {
        $items = json_decode((string) file_get_contents(database_path('data/news.json')), true) ?? [];

        $categoryIds = [];

        foreach ([
            ['最新消息', 'latest'],
            ['活動展覽', 'event'],
            ['媒體報導', 'media'],
        ] as $index => [$name, $slug]) {
            $categoryIds[$slug] = NewsCategory::query()->updateOrCreate(
                ['slug' => $slug],
                ['name' => $name, 'sort' => $index + 1],
            )->id;
        }

        News::query()->delete();

        foreach ($items as $index => $item) {
            $categoryId = $categoryIds[$item['category']] ?? null;

            if ($categoryId === null) {
                continue;
            }

            News::query()->create([
                'news_category_id' => $categoryId,
                'title' => $item['title'],
                'published_on' => $item['published_on'],
                'image' => $item['image'],
                'url' => $item['url'] ?? null,
                'sort' => $index + 1,
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
        $destination = public_path('assets/taigreat/upload/news/'.$filename);

        if (is_file($destination)) {
            return;
        }

        $directory = dirname($destination);

        if (! is_dir($directory)) {
            mkdir($directory, 0777, true);
        }

        $contents = @file_get_contents('https://www.taigreat.com.tw/upload/news/'.$filename);

        if ($contents !== false) {
            file_put_contents($destination, $contents);
        }
    }
}
