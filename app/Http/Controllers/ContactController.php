<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Models\Contact;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

/** 前台聯絡我們：顯示表單並把留言寫進 contacts。 */
class ContactController extends Controller
{
    public function create(): View
    {
        if (! session()->has('captcha_code')) {
            $this->refreshCaptcha();
        }

        return view('pages.contact');
    }

    public function store(ContactRequest $request): RedirectResponse
    {
        Contact::query()->create($request->safe()->except(['captcha', 'agree']));

        $this->refreshCaptcha();

        return back()->with('status', '已收到您的留言，我們會盡快與您聯繫。');
    }

    private function refreshCaptcha(): void
    {
        session(['captcha_code' => strtoupper(substr(str_shuffle('ABCDEFGHJKLMNPQRSTUVWXYZ23456789'), 0, 4))]);
    }
}
