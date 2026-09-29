<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\View\View;

class SustainabilityController extends Controller
{
    public function __invoke(): View
    {
        return view('pages.sustainability', [
            'page' => Page::query()->where('slug', 'sustainability')->firstOrFail(),
        ]);
    }
}
