<?php

namespace Tests\Feature;

use App\Models\News;
use App\Models\NewsCategory;
use Database\Seeders\NewsSeeder;
use Tests\TestCase;

class NewsIndexTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        if (NewsCategory::query()->count() === 0 || News::query()->count() === 0) {
            $this->seed(NewsSeeder::class);
        }
    }

    public function test_news_page_lists_items_from_the_database(): void
    {
        $item = News::query()->with('category')->orderByDesc('published_on')->first();

        $this->get(route('news'))
            ->assertOk()
            ->assertSee('全部', false)
            ->assertSee('最新消息', false)
            ->assertSee('活動展覽', false)
            ->assertSee('媒體報導', false)
            ->assertSee($item->title, false)
            ->assertSee($item->publishedLabel(), false);
    }

    public function test_news_page_can_filter_by_category(): void
    {
        $this->get(route('news', ['category' => 'media']))
            ->assertOk()
            ->assertSee('建材展-MFE 鋁合金系統模板台灣獨家代理', false);

        $this->get(route('news', ['category' => 'latest']))
            ->assertOk()
            ->assertSee('目前沒有最新消息。', false)
            ->assertDontSee('建材展-MFE 鋁合金系統模板台灣獨家代理', false);
    }
}
