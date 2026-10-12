<?php

namespace App\Support;

use Illuminate\Support\Facades\File;
use RuntimeException;

/**
 * 把 public/assets/taigreat 底下的點陣圖縮小並壓檔，
 * 同時寫一份到 optimized/ 給前台、後台預覽用。
 */
class ImageOptimizer
{
    public const MAX_WIDTH = 1920;

    public const JPEG_QUALITY = 78;

    /**
     * @var list<string>
     */
    private const EXTENSIONS = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

    public function available(): bool
    {
        return extension_loaded('gd');
    }

    public function optimizeRelative(string $relativePath): bool
    {
        $relativePath = $this->normalize($relativePath);

        if ($relativePath === '' || str_starts_with($relativePath, 'optimized/')) {
            return false;
        }

        $source = public_path('assets/taigreat/'.$relativePath);

        if (! is_file($source) || ! $this->available()) {
            return false;
        }

        $extension = strtolower(pathinfo($source, PATHINFO_EXTENSION));

        if (! in_array($extension, self::EXTENSIONS, true)) {
            return false;
        }

        $optimized = $this->writeOptimized($source, $extension);
        File::ensureDirectoryExists(dirname($source));
        File::put($source, $optimized);

        $copy = public_path('assets/taigreat/optimized/'.$relativePath);
        File::ensureDirectoryExists(dirname($copy));
        File::put($copy, $optimized);

        return true;
    }

    public function deleteOptimized(string $relativePath): void
    {
        $relativePath = $this->normalize($relativePath);

        if ($relativePath === '' || str_contains($relativePath, '..')) {
            return;
        }

        $full = public_path('assets/taigreat/optimized/'.$relativePath);
        $root = realpath(public_path('assets/taigreat/optimized'));

        if ($root === false || ! is_file($full)) {
            return;
        }

        $real = realpath($full);

        if ($real === false || ! str_starts_with($real, $root.DIRECTORY_SEPARATOR)) {
            return;
        }

        File::delete($real);
    }

    /**
     * @return list<string>
     */
    public function discoverRelativePaths(): array
    {
        $paths = [];

        foreach (['images', 'upload'] as $folder) {
            $root = public_path('assets/taigreat/'.$folder);

            if (! is_dir($root)) {
                continue;
            }

            $files = File::allFiles($root);

            foreach ($files as $file) {
                $extension = strtolower($file->getExtension());

                if (! in_array($extension, self::EXTENSIONS, true)) {
                    continue;
                }

                $paths[] = $folder.'/'.str_replace('\\', '/', $file->getRelativePathname());
            }
        }

        return $paths;
    }

    private function writeOptimized(string $source, string $extension): string
    {
        $image = $this->createImage($source, $extension);

        if ($image === false) {
            throw new RuntimeException('無法讀取圖片：'.$source);
        }

        $width = imagesx($image);
        $height = imagesy($image);

        if ($width < 1 || $height < 1) {
            imagedestroy($image);

            throw new RuntimeException('圖片尺寸無效：'.$source);
        }

        if ($width > self::MAX_WIDTH) {
            $newHeight = max(1, (int) round($height * (self::MAX_WIDTH / $width)));
            $resized = imagecreatetruecolor(self::MAX_WIDTH, $newHeight);
            $this->preserveAlpha($resized, $extension);
            imagecopyresampled($resized, $image, 0, 0, 0, 0, self::MAX_WIDTH, $newHeight, $width, $height);
            imagedestroy($image);
            $image = $resized;
        }

        if (in_array($extension, ['jpg', 'jpeg', 'webp'], true)) {
            imageinterlace($image, true);
        }

        ob_start();

        match ($extension) {
            'png' => imagepng($image, null, 6),
            'gif' => imagegif($image),
            'webp' => imagewebp($image, null, self::JPEG_QUALITY),
            default => imagejpeg($image, null, self::JPEG_QUALITY),
        };

        $contents = (string) ob_get_clean();
        imagedestroy($image);

        if ($contents === '') {
            throw new RuntimeException('無法輸出壓縮圖：'.$source);
        }

        return $contents;
    }

    private function createImage(string $path, string $extension): \GdImage|false
    {
        return match ($extension) {
            'jpg', 'jpeg' => @imagecreatefromjpeg($path),
            'png' => @imagecreatefrompng($path),
            'gif' => @imagecreatefromgif($path),
            'webp' => function_exists('imagecreatefromwebp') ? @imagecreatefromwebp($path) : false,
            default => false,
        };
    }

    private function preserveAlpha(\GdImage $image, string $extension): void
    {
        if (! in_array($extension, ['png', 'gif', 'webp'], true)) {
            return;
        }

        imagealphablending($image, false);
        imagesavealpha($image, true);
        $transparent = imagecolorallocatealpha($image, 0, 0, 0, 127);
        imagefilledrectangle($image, 0, 0, imagesx($image), imagesy($image), $transparent);
    }

    private function normalize(string $relativePath): string
    {
        return ltrim(str_replace('\\', '/', $relativePath), '/');
    }
}
