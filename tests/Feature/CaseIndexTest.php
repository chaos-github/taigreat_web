<?php

namespace Tests\Feature;

use App\Models\CaseCategory;
use App\Models\CaseItem;
use Database\Seeders\CaseSeeder;
use Tests\TestCase;

class CaseIndexTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        if (CaseItem::query()->count() === 0) {
            $this->seed(CaseSeeder::class);
        }
    }

    public function test_case_page_lists_items_from_the_database(): void
    {
        $case = CaseItem::query()->orderBy('sort')->first();

        $this->get(route('case'))
            ->assertOk()
            ->assertSee('邊坡錨固及搶險工程', false)
            ->assertSee($case->title, false)
            ->assertSee('MFE 鋁合金系統模板', false);
    }

    public function test_case_page_can_filter_by_category(): void
    {
        $category = CaseCategory::query()->where('slug', 'mfe')->first();

        $this->get(route('case', ['category' => 'mfe']))
            ->assertOk()
            ->assertSee($category->name, false)
            ->assertDontSee('邊坡錨固及搶險工程', false);
    }
}
