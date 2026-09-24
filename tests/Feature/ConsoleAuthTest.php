<?php

namespace Tests\Feature;

use App\Models\CaseCategory;
use App\Models\CaseItem;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class ConsoleAuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_from_console_to_login(): void
    {
        $this->get('/console')->assertRedirect(route('console.login'));
    }

    public function test_login_page_is_available(): void
    {
        $this->get(route('console.login'))
            ->assertOk()
            ->assertSee('登入內容中心', false)
            ->assertSee('管理官網顯示的內容', false);
    }

    public function test_user_can_login_and_see_dashboard(): void
    {
        $user = User::factory()->create([
            'name' => '內容管理員',
            'email' => 'console@taigreat.com.tw',
        ]);

        $this->post(route('console.login.store'), [
            'email' => $user->email,
            'password' => 'password',
        ])->assertRedirect(route('console.dashboard'));

        $this->get(route('console.dashboard'))
            ->assertOk()
            ->assertSee('工程實績', false)
            ->assertSee('最新消息', false)
            ->assertSee('產品與服務', false);
    }

    public function test_invalid_login_is_rejected(): void
    {
        $this->from(route('console.login'))
            ->post(route('console.login.store'), [
                'email' => 'nobody@example.com',
                'password' => 'wrong',
            ])
            ->assertRedirect(route('console.login'))
            ->assertSessionHasErrors('email');
    }

    public function test_authenticated_user_can_create_a_case(): void
    {
        $user = User::factory()->create();
        $category = CaseCategory::query()->create([
            'name' => '測試分類',
            'slug' => 'test',
            'sort' => 1,
        ]);

        $path = tempnam(sys_get_temp_dir(), 'case');
        file_put_contents($path, base64_decode('R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7'));
        $image = new UploadedFile($path, 'case.gif', 'image/gif', null, true);

        $this->actingAs($user)
            ->post(route('console.cases.store'), [
                'case_category_id' => $category->id,
                'title' => '測試工程實績',
                'image' => $image,
                'is_featured' => '1',
                'sort' => 3,
            ])
            ->assertRedirect(route('console.cases.index'));

        $this->assertDatabaseHas('cases', [
            'title' => '測試工程實績',
            'case_category_id' => $category->id,
            'is_featured' => 1,
            'sort' => 3,
        ]);

        $case = CaseItem::query()->first();
        $this->assertNotNull($case);
        $this->assertFileExists(public_path('assets/taigreat/'.$case->image));
        @unlink(public_path('assets/taigreat/'.$case->image));
    }
}
