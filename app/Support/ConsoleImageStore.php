<?php

namespace App\Support;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;

/**
 * 後台上傳圖存到 public/assets/taigreat/upload/{folder}/。
 * 資料庫只存相對路徑，例如 upload/case/xxx.jpg。
 */
class ConsoleImageStore
{
    public function store(UploadedFile $file, string $folder): string
    {
        $directory = public_path('assets/taigreat/upload/'.$folder);

        File::ensureDirectoryExists($directory);

        $name = $file->hashName();
        $file->move($directory, $name);

        return 'upload/'.$folder.'/'.$name;
    }

    /**
     * 只刪 upload/ 底下的檔，避免路徑被竄改刪到別處。
     */
    public function delete(?string $path): void
    {
        if (! is_string($path) || ! str_starts_with($path, 'upload/')) {
            return;
        }

        $full = public_path('assets/taigreat/'.$path);
        $root = realpath(public_path('assets/taigreat/upload'));

        if ($root === false || ! is_file($full)) {
            return;
        }

        $real = realpath($full);

        // 解析後必須仍在 upload 目錄內
        if ($real === false || ! str_starts_with($real, $root.DIRECTORY_SEPARATOR)) {
            return;
        }

        File::delete($real);
    }
}
