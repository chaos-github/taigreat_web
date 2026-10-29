<?php

namespace App\Http\Controllers;

use App\Models\CaseItem;
use App\Models\News;
use App\Models\Service;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __invoke(): View
    {
        return view('home', [
            'title' => '泰權興貿易',
            'featuredServices' => Service::query()
                ->select(['id', 'title', 'description', 'image', 'sort'])
                ->orderBy('sort')
                ->orderBy('id')
                ->take(4)
                ->get(),
            'featuredCases' => CaseItem::query()
                ->select(['id', 'case_category_id', 'title', 'image', 'sort'])
                ->with('category:id,name,slug')
                ->where('is_featured', true)
                ->orderBy('sort')
                ->take(5)
                ->get(),
            'latestNews' => News::query()
                ->select(['id', 'news_category_id', 'title', 'published_on', 'image', 'url', 'sort'])
                ->with('category:id,name')
                ->orderByDesc('published_on')
                ->orderBy('sort')
                ->take(2)
                ->get(),
        ]);
    }
}
