<?php

namespace Tests\Feature;

use App\Models\CaseCategory;
use App\Models\CaseItem;
use App\Models\News;
use App\Models\NewsCategory;
use App\Models\Service;
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
            ->assertSee(route('case', ['category' => 'rc']), false)
            ->assertSee('s_1.jpg', false);
    }

    public function test_homepage_shows_four_services_in_display_order_with_links_to_the_service_page(): void
    {
        foreach ([5, 2, 1, 4, 3] as $sort) {
            Service::query()->create([
                'number' => (string) $sort,
                'title' => '首頁服務項目'.$sort,
                'description' => '依現場需求提供材料與技術服務。',
                'image' => 'images/s_1.jpg',
                'sort' => $sort,
            ]);
        }

        $response = $this->get(route('home'));

        $response->assertOk()
            ->assertSeeInOrder(['首頁服務項目1', '首頁服務項目2', '首頁服務項目3', '首頁服務項目4'])
            ->assertDontSee('首頁服務項目5');

        foreach (Service::query()->where('sort', '<=', 4)->get() as $service) {
            $response->assertSee(route('service').'#service-'.$service->id, false);
        }
    }

    public function test_homepage_shows_a_contact_prompt_when_no_services_are_available(): void
    {
        $this->get(route('home'))
            ->assertOk()
            ->assertSee('產品資訊整理中，歡迎聯絡我們討論您的工程需求。');
    }
}
