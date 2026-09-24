<?php

namespace App\Http\Controllers\Console;

use App\Http\Controllers\Controller;
use App\Http\Requests\Console\ServiceRequest;
use App\Models\Service;
use App\Support\ConsoleImageStore;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ServiceController extends Controller
{
    public function __construct(private ConsoleImageStore $images) {}

    public function index(): View
    {
        return view('console.services.index', [
            'services' => Service::query()->orderBy('sort')->orderBy('id')->paginate(12),
        ]);
    }

    public function create(): View
    {
        return view('console.services.form', [
            'service' => new Service(['sort' => 0, 'links' => [['url' => '', 'label' => '']]]),
        ]);
    }

    public function store(ServiceRequest $request): RedirectResponse
    {
        Service::query()->create([
            ...$request->safe()->except(['image', 'links']),
            'links' => $request->sanitizedLinks(),
            'image' => $this->images->store($request->file('image'), 'service'),
        ]);

        return redirect()->route('console.services.index')->with('status', '產品與服務已新增。');
    }

    public function edit(Service $service): View
    {
        if ($service->links === null || $service->links === []) {
            $service->links = [['url' => '', 'label' => '']];
        }

        return view('console.services.form', [
            'service' => $service,
        ]);
    }

    public function update(ServiceRequest $request, Service $service): RedirectResponse
    {
        $data = $request->safe()->except(['image', 'links']);
        $data['links'] = $request->sanitizedLinks();

        if ($request->hasFile('image')) {
            $data['image'] = $this->images->store($request->file('image'), 'service');
        }

        $service->update($data);

        return redirect()->route('console.services.index')->with('status', '產品與服務已更新。');
    }

    public function destroy(Service $service): RedirectResponse
    {
        $service->delete();

        return redirect()->route('console.services.index')->with('status', '產品與服務已刪除。');
    }
}
