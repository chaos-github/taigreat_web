<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\NewsCategory;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NewsController extends Controller
{
    public function index(Request $request): View
    {
        $categories = NewsCategory::query()->orderBy('sort')->get();
        $currentSlug = $request->string('category')->toString();

        $news = News::query()
            ->with('category')
            ->when($currentSlug !== '', function ($query) use ($currentSlug) {
                $query->whereHas('category', fn ($category) => $category->where('slug', $currentSlug));
            })
            ->orderByDesc('published_on')
            ->orderBy('sort')
            ->orderBy('id')
            ->paginate(6)
            ->withQueryString();

        return view('pages.news', [
            'title' => '最新消息 | 泰權興貿易',
            'news' => $news,
            'categories' => $categories,
            'currentSlug' => $currentSlug,
        ]);
    }
}
