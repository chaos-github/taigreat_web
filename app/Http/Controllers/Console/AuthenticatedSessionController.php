<?php

namespace App\Http\Controllers\Console;

use App\Http\Controllers\Controller;
use App\Http\Requests\Console\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/** 後台登入 / 登出。 */
class AuthenticatedSessionController extends Controller
{
    /** 顯示登入頁。 */
    public function create(): View
    {
        return view('console.login');
    }

    /** 驗證帳密後重建 session，避免 session fixation。 */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();
        $request->session()->regenerate();

        return redirect()->intended(route('console.dashboard'));
    }

    /** 登出並作廢 session、CSRF token。 */
    public function destroy(Request $request): RedirectResponse
    {
        auth()->guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('console.login');
    }
}
