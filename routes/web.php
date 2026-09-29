<?php

use App\Http\Controllers\CaseController;
use App\Http\Controllers\Console\AuthenticatedSessionController;
use App\Http\Controllers\Console\CaseCategoryController as ConsoleCaseCategoryController;
use App\Http\Controllers\Console\CaseController as ConsoleCaseController;
use App\Http\Controllers\Console\ContactController as ConsoleContactController;
use App\Http\Controllers\Console\DashboardController;
use App\Http\Controllers\Console\NewsCategoryController as ConsoleNewsCategoryController;
use App\Http\Controllers\Console\NewsController as ConsoleNewsController;
use App\Http\Controllers\Console\ServiceController as ConsoleServiceController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\ServiceController;
use App\Models\CaseItem;
use App\Models\News;
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

Route::get('/contact', [ContactController::class, 'create'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.send');

// 後台：未登入可進登入頁；登入後才能管理前台內容
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
    Route::resource('contacts', ConsoleContactController::class)->only(['index', 'show', 'destroy']);
});
