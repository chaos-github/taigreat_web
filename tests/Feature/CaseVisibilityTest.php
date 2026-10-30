<?php

namespace Tests\Feature;

use App\Models\CaseCategory;
use App\Models\CaseItem;
use App\Models\User;
use App\Support\ConsoleImageStore;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class CaseVisibilityTest extends TestCase
{
    use RefreshDatabase;

    public function test_cases_are_enabled_by_default(): void
    {
        $case = $this->createCase('預設啟用案例');

        $this->assertTrue($case->fresh()->is_active);
    }

    public function test_disabled_cases_are_hidden_from_public_lists_and_category_filters(): void
    {
        $active = $this->createCase('前台啟用案例');
        $disabled = $this->createCase('前台停用案例', false);

        foreach ([route('case'), route('case', ['category' => $active->category->slug])] as $url) {
            $this->get($url)
                ->assertOk()
                ->assertSee($active->title)
                ->assertDontSee($disabled->title);
        }

        $this->get(route('home'))
            ->assertOk()
            ->assertSee($active->title)
            ->assertDontSee($disabled->title);
    }

    public function test_console_lists_both_statuses_and_provides_status_controls(): void
    {
        $active = $this->createCase('後台啟用案例');
        $disabled = $this->createCase('後台停用案例', false);

        $this->actingAs(User::factory()->create())
            ->get(route('console.cases.index'))
            ->assertOk()
            ->assertSee($active->title)
            ->assertSee($disabled->title)
            ->assertSee('啟用')
            ->assertSee('停用')
            ->assertSee(route('console.cases.status', $active), false)
            ->assertSee(route('console.cases.status', $disabled), false);

        $this->get(route('console.cases.edit', $disabled))
            ->assertOk()
            ->assertSee('name="is_active"', false)
            ->assertSee('value="0" selected', false);
    }

    public function test_console_can_disable_and_reenable_a_case_without_removing_its_content(): void
    {
        $case = $this->createCase('保留內容案例');
        $this->actingAs(User::factory()->create());

        $this->from(route('console.cases.index'))
            ->patch(route('console.cases.status', $case), ['is_active' => '0', 'title' => '不應改變標題'])
            ->assertRedirect(route('console.cases.index'))
            ->assertSessionHas('status', '工程實績已停用。');

        $this->assertDatabaseHas('cases', [
            'id' => $case->id,
            'is_active' => false,
            'is_featured' => true,
            'title' => '保留內容案例',
            'image' => 'images/s_1.jpg',
        ]);
        $this->get(route('case'))->assertOk()->assertDontSee($case->title);
        $this->get(route('home'))->assertOk()->assertDontSee($case->title);

        $this->from(route('console.cases.index'))
            ->patch(route('console.cases.status', $case), ['is_active' => '1'])
            ->assertRedirect(route('console.cases.index'))
            ->assertSessionHas('status', '工程實績已啟用。');

        $this->get(route('case'))->assertOk()->assertSee($case->title);
        $this->get(route('home'))->assertOk()->assertSee($case->title);
    }

    public function test_guest_cannot_change_case_status(): void
    {
        $case = $this->createCase('禁止訪客變更');

        $this->patch(route('console.cases.status', $case), ['is_active' => '0'])
            ->assertRedirect(route('console.login'));

        $this->assertTrue($case->fresh()->is_active);
    }

    public function test_invalid_status_does_not_change_the_case(): void
    {
        $case = $this->createCase('狀態驗證案例');

        $this->actingAs(User::factory()->create())
            ->from(route('console.cases.index'))
            ->patch(route('console.cases.status', $case), ['is_active' => 'invalid'])
            ->assertRedirect(route('console.cases.index'))
            ->assertSessionHasErrors('is_active');

        $this->assertTrue($case->fresh()->is_active);
    }

    public function test_edit_form_can_save_a_disabled_case(): void
    {
        $case = $this->createCase('編輯狀態案例');

        $this->actingAs(User::factory()->create())
            ->put(route('console.cases.update', $case), [
                'case_category_id' => $case->case_category_id,
                'title' => $case->title,
                'sort' => 1,
                'is_featured' => '1',
                'is_active' => '0',
            ])
            ->assertRedirect(route('console.cases.index'));

        $this->assertDatabaseHas('cases', ['id' => $case->id, 'is_active' => false]);
    }

    public function test_new_case_can_be_saved_as_disabled(): void
    {
        $category = CaseCategory::query()->create(['name' => '新增測試分類', 'slug' => 'new-case', 'sort' => 1]);
        $this->mock(ConsoleImageStore::class)
            ->shouldReceive('store')->once()->andReturn('upload/case/test-disabled.jpg');

        $this->actingAs(User::factory()->create())
            ->post(route('console.cases.store'), [
                'case_category_id' => $category->id,
                'title' => '新增停用案例',
                'image' => UploadedFile::fake()->image('case.jpg'),
                'sort' => 1,
                'is_active' => '0',
            ])
            ->assertRedirect(route('console.cases.index'));

        $this->assertDatabaseHas('cases', ['title' => '新增停用案例', 'is_active' => false]);
    }

    private function createCase(string $title, ?bool $active = null): CaseItem
    {
        $category = CaseCategory::query()->firstOrCreate(
            ['slug' => 'visibility-test'],
            ['name' => '狀態測試分類', 'sort' => 1],
        );
        $attributes = [
            'case_category_id' => $category->id,
            'title' => $title,
            'image' => 'images/s_1.jpg',
            'sort' => 1,
            'is_featured' => true,
        ];

        if ($active !== null) {
            $attributes['is_active'] = $active;
        }

        return CaseItem::query()->create($attributes);
    }
}
