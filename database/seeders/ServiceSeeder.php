<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $items = json_decode((string) file_get_contents(database_path('data/services.json')), true) ?? [];

        Service::query()->delete();

        foreach ($items as $index => $item) {
            Service::query()->create([
                'number' => $item['number'],
                'title' => $item['title'],
                'description' => $item['description'],
                'image' => $item['image'],
                'links' => $item['links'] ?? [],
                'sort' => $index + 1,
            ]);

            $this->copyImage($item['image']);
        }
    }

    private function copyImage(string $image): void
    {
        if (app()->environment('testing')) {
            return;
        }

        $filename = basename($image);
        $destination = public_path('assets/taigreat/upload/service/'.$filename);

        if (is_file($destination)) {
            return;
        }

        $directory = dirname($destination);

        if (! is_dir($directory)) {
            mkdir($directory, 0777, true);
        }

        $existing = public_path('assets/taigreat/upload/image/'.$filename);

        if (is_file($existing)) {
            copy($existing, $destination);

            return;
        }

        $contents = @file_get_contents('https://www.taigreat.com.tw/upload/image/'.$filename);

        if ($contents !== false) {
            file_put_contents($destination, $contents);
        }
    }
}
