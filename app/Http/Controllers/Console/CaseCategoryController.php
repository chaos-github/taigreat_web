<?php

namespace App\Http\Controllers\Console;

use App\Http\Controllers\Controller;
use App\Http\Requests\Console\CaseCategoryRequest;
use App\Models\CaseCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CaseCategoryController extends Controller
{
    public function index(): View
    {
        return view('console.case-categories.index', [
            'categories' => CaseCategory::query()->withCount('cases')->orderBy('sort')->get(),
            'category' => new CaseCategory(['sort' => 0]),
        ]);
    }

    public function store(CaseCategoryRequest $request): RedirectResponse
    {
        CaseCategory::query()->create($request->validated());

        return redirect()->route('console.case-categories.index')->with('status', '分類已新增。');
    }

    public function edit(CaseCategory $caseCategory): View
    {
        return view('console.case-categories.index', [
            'categories' => CaseCategory::query()->withCount('cases')->orderBy('sort')->get(),
            'category' => $caseCategory,
        ]);
    }

    public function update(CaseCategoryRequest $request, CaseCategory $caseCategory): RedirectResponse
    {
        $caseCategory->update($request->validated());

        return redirect()->route('console.case-categories.index')->with('status', '分類已更新。');
    }

    public function destroy(CaseCategory $caseCategory): RedirectResponse
    {
        if ($caseCategory->cases()->exists()) {
            return back()->withErrors(['category' => '此分類尚有工程實績，無法刪除。']);
        }

        $caseCategory->delete();

        return redirect()->route('console.case-categories.index')->with('status', '分類已刪除。');
    }
}
