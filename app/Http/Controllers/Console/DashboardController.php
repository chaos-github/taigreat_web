<?php

namespace App\Http\Controllers\Console;

use App\Http\Controllers\Controller;
use App\Models\CaseItem;
use App\Models\News;
use App\Models\Service;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        return view('console.dashboard', [
            'caseCount' => CaseItem::query()->count(),
            'newsCount' => News::query()->count(),
            'serviceCount' => Service::query()->count(),
            'featuredCount' => CaseItem::query()->where('is_featured', true)->count(),
            'latestNews' => News::query()->with('category')->orderByDesc('published_on')->limit(5)->get(),
            'featuredCases' => CaseItem::query()->with('category')->where('is_featured', true)->orderBy('sort')->limit(5)->get(),
        ]);
    }
}
