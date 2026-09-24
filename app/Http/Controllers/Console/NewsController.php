<?php

namespace App\Http\Controllers\Console;

use App\Http\Controllers\Controller;
use App\Http\Requests\Console\NewsRequest;
use App\Models\News;
use App\Models\NewsCategory;
use App\Support\ConsoleImageStore;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

/** 後台最新消息 CRUD，圖片走 ConsoleImageStore。 */
class NewsController extends Controller
{
    public function __construct(private ConsoleImageStore $images) {}

    public function index(): View
    {
        return view('console.news.index', [
            'news' => News::query()
                ->with('category')
                ->orderByDesc('published_on')
                ->orderBy('sort')
                ->paginate(12),
        ]);
    }

    public function create(): View
    {
        return view('console.news.form', [
            'item' => new News(['published_on' => now(), 'sort' => 0]),
            'categories' => NewsCategory::query()->orderBy('sort')->get(),
        ]);
    }

    public function store(NewsRequest $request): RedirectResponse
    {
        News::query()->create([
            ...$request->safe()->except('image'),
            'image' => $this->images->store($request->file('image'), 'news'),
        ]);

        return redirect()->route('console.news.index')->with('status', '最新消息已新增。');
    }

    public function edit(News $news): View
    {
        return view('console.news.form', [
            'item' => $news,
            'categories' => NewsCategory::query()->orderBy('sort')->get(),
        ]);
    }

    public function update(NewsRequest $request, News $news): RedirectResponse
    {
        $data = $request->safe()->except('image');

        if ($request->hasFile('image')) {
            $previous = $news->image;
            $data['image'] = $this->images->store($request->file('image'), 'news');
            $this->images->delete($previous); // 先存新圖再刪舊圖
        }

        $news->update($data);

        return redirect()->route('console.news.index')->with('status', '最新消息已更新。');
    }

    public function destroy(News $news): RedirectResponse
    {
        $this->images->delete($news->image); // 刪資料列前先刪實體圖
        $news->delete();

        return redirect()->route('console.news.index')->with('status', '最新消息已刪除。');
    }
}
