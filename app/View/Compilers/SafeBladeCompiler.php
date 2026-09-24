<?php

namespace App\View\Compilers;

use Illuminate\View\Compilers\BladeCompiler;

class SafeBladeCompiler extends BladeCompiler
{
    /**
     * 編譯 Blade。不使用 Laravel 原版的 tempnam() / touch()，
     * 避免 Windows Docker 掛載磁碟寫入失敗。
     */
    public function compile($path = null)
    {
        if ($path) {
            $this->setPath($path);
        }

        // 未設定編譯快取目錄時不寫檔，只編譯到記憶體
        if (is_null($this->cachePath)) {
            return;
        }

        // 讀取 .blade.php，編成一般 PHP
        $contents = $this->compileString($this->files->get($this->getPath()));

        // 在編譯結果附上原始檔路徑，除錯時才知道對應哪個 blade
        if ($this->getPath() !== '') {
            $contents = $this->appendFilePath($contents);
        }

        $compiledPath = $this->getCompiledPath($this->getPath());
        $this->ensureCompiledDirectoryExists($compiledPath);
        // 直接覆寫編譯檔，不走 replace() + touch()
        $this->files->put($compiledPath, $contents);
    }
}
