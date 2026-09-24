<?php

namespace App\Http\Controllers\Console;

use App\Http\Controllers\Controller;
use App\Http\Requests\Console\CaseRequest;
use App\Models\CaseCategory;
use App\Models\CaseItem;
use App\Support\ConsoleImageStore;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

/** 後台工程實績 CRUD，圖片走 ConsoleImageStore。 */
class CaseController extends Controller
{
    public function __construct(private ConsoleImageStore $images) {}

    public function index(): View
    {
        return view('console.cases.index', [
            'cases' => CaseItem::query()
                ->with('category')
                ->orderBy('sort')
                ->orderByDesc('id')
                ->paginate(12),
        ]);
    }

    public function create(): View
    {
        return view('console.cases.form', [
            'caseItem' => new CaseItem(['sort' => 0, 'is_featured' => false]),
            'categories' => CaseCategory::query()->orderBy('sort')->get(),
        ]);
    }

    public function store(CaseRequest $request): RedirectResponse
    {
        CaseItem::query()->create([
            ...$request->safe()->except('image'),
            'image' => $this->images->store($request->file('image'), 'case'),
        ]);

        return redirect()->route('console.cases.index')->with('status', '工程實績已新增。');
    }

    public function edit(CaseItem $case): View
    {
        return view('console.cases.form', [
            'caseItem' => $case,
            'categories' => CaseCategory::query()->orderBy('sort')->get(),
        ]);
    }

    public function update(CaseRequest $request, CaseItem $case): RedirectResponse
    {
        $data = $request->safe()->except('image');

        if ($request->hasFile('image')) {
            $previous = $case->image;
            $data['image'] = $this->images->store($request->file('image'), 'case');
            $this->images->delete($previous); // 先存新圖再刪舊圖
        }

        $case->update($data);

        return redirect()->route('console.cases.index')->with('status', '工程實績已更新。');
    }

    public function destroy(CaseItem $case): RedirectResponse
    {
        $this->images->delete($case->image); // 刪資料列前先刪實體圖
        $case->delete();

        return redirect()->route('console.cases.index')->with('status', '工程實績已刪除。');
    }
}
