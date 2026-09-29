<?php

namespace App\Http\Controllers\Console;

use App\Http\Controllers\Controller;
use App\Http\Requests\Console\PageRequest;
use App\Models\Page;
use App\Support\ConsoleImageStore;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/** 後台編輯關於我們、永續發展固定頁。 */
class PageController extends Controller
{
    public function __construct(private ConsoleImageStore $images) {}

    public function edit(Request $request): View
    {
        return view('console.pages.form', [
            'page' => Page::query()->where('slug', $this->slug($request))->firstOrFail(),
        ]);
    }

    public function update(PageRequest $request): RedirectResponse
    {
        $slug = $this->slug($request);
        $page = Page::query()->where('slug', $slug)->firstOrFail();
        $data = $request->safe()->only([
            'heading',
            'heading_en',
            'eyebrow',
            'subtitle',
            'lead',
            'body',
        ]);
        $data['title'] = $data['heading'].' | 泰權興貿易';
        $data['extra'] = $request->extraPayload();

        if ($request->hasFile('banner_image')) {
            $previous = $page->banner_image;
            $data['banner_image'] = $this->images->store($request->file('banner_image'), 'page');
            $this->images->delete($previous);
        }

        if ($request->hasFile('image')) {
            $previous = $page->image;
            $data['image'] = $this->images->store($request->file('image'), 'page');
            $this->images->delete($previous);
        }

        $page->update($data);

        $label = $slug === 'about' ? '關於我們' : '永續發展';

        return redirect()
            ->route('console.'.$slug.'.edit')
            ->with('status', $label.'已更新。');
    }

    private function slug(Request $request): string
    {
        return $request->routeIs('console.about.*') ? 'about' : 'sustainability';
    }
}
