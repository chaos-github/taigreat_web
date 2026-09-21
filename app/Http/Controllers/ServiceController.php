<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\View\View;

class ServiceController extends Controller
{
    public function index(): View
    {
        return view('pages.service', [
            'title' => '產品與服務 | 泰權興貿易',
            'services' => Service::query()
                ->orderBy('sort')
                ->orderBy('id')
                ->paginate(10)
                ->withQueryString(),
        ]);
    }
}
