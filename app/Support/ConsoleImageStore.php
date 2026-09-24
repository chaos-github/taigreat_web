<?php

namespace App\Support;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;

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
}
