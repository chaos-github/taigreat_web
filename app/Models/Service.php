<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\HtmlString;

#[Fillable(['number', 'title', 'description', 'image', 'links', 'sort'])]
class Service extends Model
{
    protected function casts(): array
    {
        return [
            'links' => 'array',
        ];
    }

    public function imageUrl(): string
    {
        return asset('assets/taigreat/'.$this->image);
    }

    /** 後台說明的換行轉成 br，並跳脫 HTML 防 XSS。 */
    public function safeDescription(): HtmlString
    {
        $text = preg_replace('/<br\s*\/?>/i', "\n", (string) $this->description) ?? '';
        $text = preg_replace("/\r\n|\r/", "\n", $text) ?? $text;
        $text = trim(preg_replace("/\n{3,}/", "\n\n", $text) ?? $text);

        return new HtmlString(nl2br(e($text), false));
    }
}
