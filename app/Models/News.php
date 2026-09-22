<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['news_category_id', 'title', 'published_on', 'image', 'url', 'sort'])]
class News extends Model
{
    protected function casts(): array
    {
        return [
            'published_on' => 'date',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(NewsCategory::class, 'news_category_id');
    }

    public function imageUrl(): string
    {
        return asset('assets/taigreat/'.$this->image);
    }

    public function publishedLabel(): string
    {
        return $this->published_on->format('Y.m.d');
    }
}
