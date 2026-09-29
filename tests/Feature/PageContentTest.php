<?php

namespace Tests\Feature;

use App\Models\Page;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PageContentTest extends TestCase
{
    use RefreshDatabase;

    public function test_about_page_shows_database_content(): void
    {
        $this->get(route('about'))
            ->assertOk()
            ->assertSee('公司簡介', false)
            ->assertSee('使命', false);
    }

    public function test_sustainability_page_shows_database_content(): void
    {
        $this->get(route('sustainability'))
            ->assertOk()
            ->assertSee('用更好的材料與工法', false)
            ->assertSee('環境友善', false);
    }

    public function test_console_can_edit_the_about_and_sustainability_pages(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('console.about.edit'))
            ->assertOk()
            ->assertSee('公司簡介', false)
            ->assertSee('使命', false);

        $this->actingAs($user)
            ->get(route('console.sustainability.edit'))
            ->assertOk()
            ->assertSee('用更好的材料與工法', false)
            ->assertSee('環境友善', false);
    }

    public function test_console_can_update_the_about_page(): void
    {
        $user = User::factory()->create();
        $page = Page::query()->where('slug', 'about')->first();

        $this->actingAs($user)
            ->put(route('console.about.update'), [
                'heading' => '關於我們改',
                'heading_en' => 'ABOUT US',
                'eyebrow' => 'Company',
                'subtitle' => '公司簡介改',
                'lead' => '引言改',
                'body' => '內文改',
                'mission_eyebrow' => 'Mission',
                'mission_title' => '使命',
                'mission_body' => '使命內文',
                'mission_en' => "line one\nline two",
            ])
            ->assertRedirect(route('console.about.edit'));

        $this->assertDatabaseHas('pages', [
            'id' => $page->id,
            'heading' => '關於我們改',
            'subtitle' => '公司簡介改',
            'body' => '內文改',
        ]);

        $this->get(route('about'))
            ->assertOk()
            ->assertSee('公司簡介改', false)
            ->assertSee('內文改', false);
    }

    public function test_console_can_update_the_sustainability_page(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->put(route('console.sustainability.update'), [
                'heading' => '永續發展',
                'heading_en' => 'SUSTAINABILITY',
                'eyebrow' => 'Our commitment',
                'subtitle' => '用更好的材料與工法',
                'body' => '更新後的永續內文',
                'stats' => [
                    ['title' => '環境友善', 'text' => '說明一'],
                    ['title' => '社會責任', 'text' => '說明二'],
                    ['title' => '綠色建築', 'text' => '說明三'],
                ],
            ])
            ->assertRedirect(route('console.sustainability.edit'));

        $this->get(route('sustainability'))
            ->assertOk()
            ->assertSee('更新後的永續內文', false)
            ->assertSee('說明三', false);
    }
}
