<?php

namespace Tests\Feature;

use App\Support\ConsoleImageStore;
use App\Support\ImageOptimizer;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class ImageOptimizerTest extends TestCase
{
    public function test_console_upload_writes_an_optimized_copy_when_gd_is_available(): void
    {
        if (! extension_loaded('gd')) {
            $this->markTestSkipped('需要 GD 才能驗證上傳壓圖。');
        }

        $store = app(ConsoleImageStore::class);
        $relative = $store->store($this->jpegUpload(), 'case');

        $this->assertFileExists(public_path('assets/taigreat/'.$relative));
        $this->assertFileExists(public_path('assets/taigreat/optimized/'.$relative));

        $store->delete($relative);

        $this->assertFileDoesNotExist(public_path('assets/taigreat/'.$relative));
        $this->assertFileDoesNotExist(public_path('assets/taigreat/optimized/'.$relative));
    }

    public function test_optimizer_skips_when_gd_is_missing(): void
    {
        $optimizer = new ImageOptimizer;

        if ($optimizer->available()) {
            $this->assertTrue($optimizer->available());

            return;
        }

        $this->assertFalse($optimizer->optimizeRelative('images/missing-file.jpg'));
    }

    private function jpegUpload(): UploadedFile
    {
        $path = tempnam(sys_get_temp_dir(), 'jpg');
        $image = imagecreatetruecolor(2200, 1200);
        imagefilledrectangle($image, 0, 0, 2199, 1199, imagecolorallocate($image, 20, 40, 60));
        imagejpeg($image, $path, 95);
        imagedestroy($image);

        return new UploadedFile($path, 'wide.jpg', 'image/jpeg', null, true);
    }
}
