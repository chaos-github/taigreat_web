<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\View\View;

class AboutController extends Controller
{
    public function __invoke(): View
    {
        return view('pages.about', [
            'page' => Page::query()->where('slug', 'about')->firstOrFail(),
        ]);
    }
}
