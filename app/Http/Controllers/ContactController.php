<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Models\Contact;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

/** 前台聯絡我們：顯示表單並把留言寫進 contacts。 */
class ContactController extends Controller
{
    public function create(): View
    {
        $this->refreshCaptcha();

        return view('pages.contact');
    }

    public function store(ContactRequest $request): RedirectResponse
    {
        Contact::query()->create($request->safe()->except(['captcha', 'agree', 'website']));

        $this->refreshCaptcha();

        return back()->with('status', '已收到您的留言，我們會盡快與您聯繫。');
    }

    public function captcha(): Response
    {
        if (! session()->has('captcha_code')) {
            $this->refreshCaptcha();
        }

        $image = imagecreatetruecolor(160, 54);
        $background = imagecolorallocate($image, 244, 243, 238);
        imagefill($image, 0, 0, $background);
        $noise = imagecolorallocate($image, 180, 190, 190);

        for ($i = 0; $i < 8; $i++) {
            imageline($image, random_int(0, 159), random_int(0, 53), random_int(0, 159), random_int(0, 53), $noise);
        }

        $ink = imagecolorallocate($image, 16, 44, 54);
        foreach (str_split((string) session('captcha_code')) as $i => $character) {
            imagestring($image, 5, 20 + $i * 24, random_int(12, 22), $character, $ink);
        }

        ob_start();
        imagepng($image);
        $contents = (string) ob_get_clean();
        imagedestroy($image);

        return response($contents, 200, [
            'Content-Type' => 'image/png',
            'Cache-Control' => 'no-store, private, max-age=0',
        ]);
    }

    private function refreshCaptcha(): void
    {
        $alphabet = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';
        $code = '';
        for ($i = 0; $i < 5; $i++) {
            $code .= $alphabet[random_int(0, strlen($alphabet) - 1)];
        }
        session(['captcha_code' => $code]);
    }
}
