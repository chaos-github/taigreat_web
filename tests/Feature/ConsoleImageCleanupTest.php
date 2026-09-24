<?php

namespace Tests\Feature;

use App\Models\CaseCategory;
use App\Models\CaseItem;
use App\Models\News;
use App\Models\NewsCategory;
use App\Models\Service;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

/** 後台刪除工程實績 / 消息 / 服務時，實體圖也要一併刪掉。 */
class ConsoleImageCleanupTest extends TestCase
{
    use RefreshDatabase;

    public function test_deleting_a_case_removes_its_image(): void
    {
        $user = User::factory()->create();
        $category = CaseCategory::query()->create([
            'name' => '測試分類',
            'slug' => 'test-case',
            'sort' => 1,
        ]);

        $this->actingAs($user)
            ->post(route('console.cases.store'), [
                'case_category_id' => $category->id,
                'title' => '待刪工程',
                'image' => $this->gifUpload('case.gif'),
                'is_featured' => '0',
                'sort' => 1,
            ])
            ->assertRedirect(route('console.cases.index'));

        $case = CaseItem::query()->first();
        $this->assertNotNull($case);
        $path = public_path('assets/taigreat/'.$case->image);
        $this->assertFileExists($path);

        $this->actingAs($user)
            ->delete(route('console.cases.destroy', $case))
            ->assertRedirect(route('console.cases.index'));

        $this->assertDatabaseMissing('cases', ['id' => $case->id]);
        $this->assertFileDoesNotExist($path);
    }

    public function test_deleting_news_removes_its_image(): void
    {
        $user = User::factory()->create();
        $category = NewsCategory::query()->create([
            'name' => '測試消息',
            'slug' => 'test-news',
            'sort' => 1,
        ]);

        $this->actingAs($user)
            ->post(route('console.news.store'), [
                'news_category_id' => $category->id,
                'title' => '待刪消息',
                'published_on' => '2026-09-24',
                'image' => $this->gifUpload('news.gif'),
                'sort' => 1,
            ])
            ->assertRedirect(route('console.news.index'));

        $news = News::query()->first();
        $this->assertNotNull($news);
        $path = public_path('assets/taigreat/'.$news->image);
        $this->assertFileExists($path);

        $this->actingAs($user)
            ->delete(route('console.news.destroy', $news))
            ->assertRedirect(route('console.news.index'));

        $this->assertDatabaseMissing('news', ['id' => $news->id]);
        $this->assertFileDoesNotExist($path);
    }

    public function test_deleting_a_service_removes_its_image(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('console.services.store'), [
                'number' => '01',
                'title' => '待刪服務',
                'description' => '說明',
                'image' => $this->gifUpload('service.gif'),
                'sort' => 1,
            ])
            ->assertRedirect(route('console.services.index'));

        $service = Service::query()->first();
        $this->assertNotNull($service);
        $path = public_path('assets/taigreat/'.$service->image);
        $this->assertFileExists($path);

        $this->actingAs($user)
            ->delete(route('console.services.destroy', $service))
            ->assertRedirect(route('console.services.index'));

        $this->assertDatabaseMissing('services', ['id' => $service->id]);
        $this->assertFileDoesNotExist($path);
    }

    /** 1x1 GIF，測試環境不需 GD。 */
    private function gifUpload(string $name): UploadedFile
    {
        $path = tempnam(sys_get_temp_dir(), 'img');
        file_put_contents($path, base64_decode('R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7'));

        return new UploadedFile($path, $name, 'image/gif', null, true);
    }
}
