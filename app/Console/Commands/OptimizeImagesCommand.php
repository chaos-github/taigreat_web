<?php

namespace App\Console\Commands;

use App\Support\ImageOptimizer;
use Illuminate\Console\Command;

class OptimizeImagesCommand extends Command
{
    protected $signature = 'images:optimize';

    protected $description = '壓縮 public/assets/taigreat 的 images、upload 圖片';

    public function handle(ImageOptimizer $optimizer): int
    {
        if (! $optimizer->available()) {
            $this->error('需要 PHP GD 擴充才能壓圖。');

            return self::FAILURE;
        }

        $paths = $optimizer->discoverRelativePaths();
        $ok = 0;
        $failed = 0;

        foreach ($paths as $path) {
            try {
                if ($optimizer->optimizeRelative($path)) {
                    $this->line($path);
                    $ok++;
                }
            } catch (\Throwable $e) {
                $this->warn($path.'：'.$e->getMessage());
                $failed++;
            }
        }

        $this->info("完成 {$ok} 張".($failed > 0 ? "，失敗 {$failed} 張" : '').'。');

        return $failed > 0 ? self::FAILURE : self::SUCCESS;
    }
}
