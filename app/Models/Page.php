<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\HtmlString;

#[Fillable([
    'slug',
    'title',
    'banner_image',
    'heading',
    'heading_en',
    'image',
    'eyebrow',
    'subtitle',
    'lead',
    'body',
    'extra',
])]
class Page extends Model
{
    protected function casts(): array
    {
        return [
            'extra' => 'array',
        ];
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function imageUrl(): string
    {
        return asset('assets/taigreat/'.$this->image);
    }

    public function bannerUrl(): string
    {
        return asset('assets/taigreat/'.$this->banner_image);
    }

    public function extraValue(string $key, string $default = ''): string
    {
        $value = $this->extra[$key] ?? $default;

        return is_string($value) ? $value : $default;
    }

    /**
     * @return list<array{title: string, text: string}>
     */
    public function stats(): array
    {
        $stats = $this->extra['stats'] ?? [];

        if (! is_array($stats)) {
            return [];
        }

        return array_values(array_map(fn (array $stat): array => [
            'title' => (string) ($stat['title'] ?? ''),
            'text' => (string) ($stat['text'] ?? ''),
        ], $stats));
    }

    public function safeLead(): HtmlString
    {
        return $this->toSafeHtml((string) $this->lead);
    }

    public function safeBody(): HtmlString
    {
        return $this->toSafeHtml($this->body);
    }

    public function safeExtra(string $key): HtmlString
    {
        return $this->toSafeHtml($this->extraValue($key));
    }

    private function toSafeHtml(string $text): HtmlString
    {
        $text = preg_replace('/<br\s*\/?>/i', "\n", $text) ?? $text;
        $text = preg_replace("/\r\n|\r/", "\n", $text) ?? $text;

        return new HtmlString(nl2br(e($text), false));
    }
}
