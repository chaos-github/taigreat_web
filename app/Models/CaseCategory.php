<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['name', 'slug', 'sort'])]
class CaseCategory extends Model
{
    public function cases(): HasMany
    {
        return $this->hasMany(CaseItem::class, 'case_category_id');
    }
}
