<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['case_category_id', 'title', 'image', 'sort', 'is_featured'])]
class CaseItem extends Model
{
    protected $table = 'cases';

    protected function casts(): array
    {
        return [
            'is_featured' => 'boolean',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(CaseCategory::class, 'case_category_id');
    }

    public function imageUrl(): string
    {
        return asset('assets/taigreat/'.$this->image);
    }
}
