<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\HtmlString;

#[Fillable(['name', 'company', 'tel', 'email', 'subject', 'content'])]
class Contact extends Model
{
    public function safeContent(): HtmlString
    {
        $text = preg_replace("/\r\n|\r/", "\n", (string) $this->content) ?? '';

        return new HtmlString(nl2br(e($text), false));
    }
}
