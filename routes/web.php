<?php

use App\Http\Controllers\CaseController;
use App\Http\Controllers\Console\AuthenticatedSessionController;
use App\Http\Controllers\Console\CaseCategoryController as ConsoleCaseCategoryController;
use App\Http\Controllers\Console\CaseController as ConsoleCaseController;
use App\Http\Controllers\Console\DashboardController;
use App\Http\Controllers\Console\NewsCategoryController as ConsoleNewsCategoryController;
use App\Http\Controllers\Console\NewsController as ConsoleNewsController;
use App\Http\Controllers\Console\ServiceController as ConsoleServiceController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\ServiceController;
use App\Models\CaseItem;
use App\Models\News;
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
        'latestNews' => News::query()
            ->with('category')
            ->orderByDesc('published_on')
            ->orderBy('sort')
            ->take(2)
            ->get(),
    ]);
})->name('home');
Route::view('/about', 'pages.about')->name('about');
Route::get('/news', [NewsController::class, 'index'])->name('news');
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

Route::middleware('guest')->group(function () {
    Route::get('/console/login', [AuthenticatedSessionController::class, 'create'])->name('console.login');
    Route::post('/console/login', [AuthenticatedSessionController::class, 'store'])->name('console.login.store');
});

Route::middleware('auth')->prefix('console')->name('console.')->group(function () {
    Route::get('/', DashboardController::class)->name('dashboard');
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

    Route::resource('cases', ConsoleCaseController::class)->except('show');
    Route::resource('case-categories', ConsoleCaseCategoryController::class)->except(['show', 'create']);
    Route::resource('news', ConsoleNewsController::class)->except('show');
    Route::resource('news-categories', ConsoleNewsCategoryController::class)->except(['show', 'create']);
    Route::resource('services', ConsoleServiceController::class)->except('show');
});
