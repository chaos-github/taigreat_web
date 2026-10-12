<?php

namespace App\Support;

/** 首頁等頁面優先用壓縮過的圖；沒有壓縮檔就回原圖。 */
class OptimizedImage
{
    public static function url(string $relativePath): string
    {
        $relativePath = ltrim(str_replace('\\', '/', $relativePath), '/');
        $optimized = public_path('assets/taigreat/optimized/'.$relativePath);

        if (is_file($optimized)) {
            return asset('assets/taigreat/optimized/'.$relativePath);
        }

        return asset('assets/taigreat/'.$relativePath);
    }
}
