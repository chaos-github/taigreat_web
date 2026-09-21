<?php

namespace Tests\Feature;

use App\Models\Service;
use Database\Seeders\ServiceSeeder;
use Tests\TestCase;

class ServiceIndexTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        if (Service::query()->count() === 0) {
            $this->seed(ServiceSeeder::class);
        }
    }

    public function test_service_page_lists_items_from_the_database(): void
    {
        $services = Service::query()->orderBy('sort')->orderBy('id')->get();

        $this->get(route('service'))
            ->assertOk()
            ->assertSee($services[0]->title, false)
            ->assertSee($services[1]->title, false)
            ->assertDontSee($services[2]->title, false)
            ->assertSee('下一頁', false);
    }

    public function test_service_page_can_open_the_second_page(): void
    {
        $services = Service::query()->orderBy('sort')->orderBy('id')->get();

        $this->get(route('service', ['page' => 2]))
            ->assertOk()
            ->assertSee($services[2]->title, false)
            ->assertSee($services[3]->title, false)
            ->assertDontSee($services[0]->title, false);
    }
}
