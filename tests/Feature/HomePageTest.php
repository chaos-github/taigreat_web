<?php

namespace Tests\Feature;

use App\Models\CaseCategory;
use App\Models\CaseItem;
use App\Models\News;
use App\Models\NewsCategory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomePageTest extends TestCase
{
    use RefreshDatabase;

    public function test_homepage_renders_featured_content(): void
    {
        $caseCategory = CaseCategory::query()->create([
            'name' => 'RC',
            'slug' => 'rc',
            'sort' => 1,
        ]);

        CaseItem::query()->create([
            'case_category_id' => $caseCategory->id,
            'title' => '首頁精選實績',
            'image' => 'images/s_1.jpg',
            'is_featured' => true,
            'sort' => 1,
        ]);

        $newsCategory = NewsCategory::query()->where('slug', 'latest')->firstOrFail();

        News::query()->create([
            'news_category_id' => $newsCategory->id,
            'title' => '首頁最新消息',
            'published_on' => '2026-10-01',
            'image' => 'images/s_2.jpg',
            'sort' => 1,
        ]);

        $this->get(route('home'))
            ->assertOk()
            ->assertSee('以專業建構', false)
            ->assertSee('首頁精選實績', false)
            ->assertSee('首頁最新消息', false)
            ->assertSee('s_1.jpg', false);
    }
}
