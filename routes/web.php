<?php

use App\Http\Controllers\CaseController;
use App\Http\Controllers\ServiceController;
use App\Models\CaseItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home', [
        'title' => '泰權興貿易',
        'featuredCases' => CaseItem::query()
            ->with('category')
            ->where('is_featured', true)
            ->orderBy('sort')
            ->take(5)
            ->get(),
    ]);
})->name('home');
Route::view('/about', 'pages.about')->name('about');
Route::view('/news', 'pages.news')->name('news');
Route::get('/case', [CaseController::class, 'index'])->name('case');
Route::get('/service', [ServiceController::class, 'index'])->name('service');
Route::view('/sustainability', 'pages.sustainability')->name('sustainability');

Route::get('/contact', function () {
    if (! session()->has('captcha_code')) {
        session(['captcha_code' => strtoupper(substr(str_shuffle('ABCDEFGHJKLMNPQRSTUVWXYZ23456789'), 0, 4))]);
    }

    return view('pages.contact');
})->name('contact');

Route::post('/contact', function (Request $request) {
    $request->validate([
        'name' => 'required|string|max:100',
        'email' => 'required|email',
        'subject' => 'required|string|max:200',
        'content' => 'required|string',
        'captcha' => 'required',
        'agree' => 'accepted',
    ]);

    if (strtoupper((string) $request->input('captcha')) !== session('captcha_code')) {
        return back()->withErrors(['captcha' => '驗證碼不正確'])->withInput();
    }

    session(['captcha_code' => strtoupper(substr(str_shuffle('ABCDEFGHJKLMNPQRSTUVWXYZ23456789'), 0, 4))]);

    return back()->with('status', '已收到您的留言，我們會盡快與您聯繫。');
})->name('contact.send');
