<?php

namespace App\Http\Controllers;

use App\Models\CaseCategory;
use App\Models\CaseItem;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CaseController extends Controller
{
    public function index(Request $request): View
    {
        $categories = CaseCategory::query()->orderBy('sort')->get();
        $currentSlug = $request->string('category')->toString();

        $cases = CaseItem::query()
            ->with('category')
            ->when($currentSlug !== '', function ($query) use ($currentSlug) {
                $query->whereHas('category', fn ($category) => $category->where('slug', $currentSlug));
            })
            ->orderBy('sort')
            ->orderBy('id')
            ->paginate(6)
            ->withQueryString();

        return view('pages.case', [
            'title' => '工程實績 | 泰權興貿易',
            'categories' => $categories,
            'cases' => $cases,
            'currentSlug' => $currentSlug,
        ]);
    }
}
