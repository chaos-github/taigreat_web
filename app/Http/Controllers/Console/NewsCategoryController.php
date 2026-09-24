<?php

namespace App\Http\Controllers\Console;

use App\Http\Controllers\Controller;
use App\Http\Requests\Console\NewsCategoryRequest;
use App\Models\NewsCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class NewsCategoryController extends Controller
{
    public function index(): View
    {
        return view('console.news-categories.index', [
            'categories' => NewsCategory::query()->withCount('news')->orderBy('sort')->get(),
            'category' => new NewsCategory(['sort' => 0]),
        ]);
    }

    public function store(NewsCategoryRequest $request): RedirectResponse
    {
        NewsCategory::query()->create($request->validated());

        return redirect()->route('console.news-categories.index')->with('status', '分類已新增。');
    }

    public function edit(NewsCategory $newsCategory): View
    {
        return view('console.news-categories.index', [
            'categories' => NewsCategory::query()->withCount('news')->orderBy('sort')->get(),
            'category' => $newsCategory,
        ]);
    }

    public function update(NewsCategoryRequest $request, NewsCategory $newsCategory): RedirectResponse
    {
        $newsCategory->update($request->validated());

        return redirect()->route('console.news-categories.index')->with('status', '分類已更新。');
    }

    public function destroy(NewsCategory $newsCategory): RedirectResponse
    {
        if ($newsCategory->news()->exists()) {
            return back()->withErrors(['category' => '此分類尚有消息，無法刪除。']);
        }

        $newsCategory->delete();

        return redirect()->route('console.news-categories.index')->with('status', '分類已刪除。');
    }
}
