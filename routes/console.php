<?php

use App\Models\User;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('console:password {email} {--create : Create a new administrator if missing}', function () {
    $email = (string) $this->argument('email');
    $validation = Validator::make(['email' => $email], ['email' => ['required', 'email']]);
    if ($validation->fails()) {
        $this->error('請提供有效的電子信箱。');

        return 1;
    }

    $user = User::query()->where('email', $email)->first();
    if (! $user && ! $this->option('create')) {
        $this->error('找不到帳號。若要建立新管理員，請明確指定 --create。');

        return 1;
    }

    $password = $this->secret('請輸入新密碼（至少 12 字元，含大小寫、數字與符號）');
    $confirmation = $this->secret('請再次輸入新密碼');
    $validator = Validator::make(
        ['password' => $password, 'password_confirmation' => $confirmation],
        ['password' => ['required', 'confirmed', Password::min(12)->mixedCase()->numbers()->symbols()]],
    );
    if ($validator->fails()) {
        $this->error('密碼不符合要求或兩次輸入不一致，帳號未變更。');

        return 1;
    }

    $user ??= new User(['name' => '內容管理員', 'email' => $email]);
    $user->password = $password;
    $user->remember_token = Str::random(60);
    $user->save();
    DB::table('sessions')->where('user_id', $user->id)->delete();
    $this->info('管理員密碼已更新，既有登入已失效。');

    return 0;
})->purpose('Interactively set an administrator password without printing or passing it on the command line');

Artisan::command('security:check', function () {
    $errors = [];
    if (! app()->isProduction()) {
        $errors[] = 'APP_ENV 必須為 production。';
    }
    if (config('app.debug')) {
        $errors[] = 'APP_DEBUG 必須關閉。';
    }
    $host = parse_url((string) config('app.url'), PHP_URL_HOST);
    if (! str_starts_with((string) config('app.url'), 'https://') || ! $host || $host === 'YOUR_DOMAIN' || $host === 'localhost') {
        $errors[] = 'APP_URL 必須設定為正式 HTTPS 網址。';
    }
    $connection = config('database.default');
    $username = (string) config('database.connections.'.$connection.'.username');
    $dbPassword = (string) config('database.connections.'.$connection.'.password');
    if ($username === 'root' || strlen($dbPassword) < 16 || in_array(strtolower($dbPassword), ['password', 'root'], true)) {
        $errors[] = '資料庫必須使用非 root 的專用帳號與至少 16 字元的強密碼。';
    }
    if (! config('session.secure') || ! config('session.http_only')) {
        $errors[] = '正式 Session Cookie 必須啟用 Secure 與 HttpOnly。';
    }
    if (config('console.allow_private_networks')) {
        $errors[] = '正式後台必須關閉整個私有網段的預設放行，改用明確 IP 白名單。';
    }
    if (config('boost.enabled', false)) {
        $errors[] = '正式環境必須停用 Boost 執行端點。';
    }
    if (! config('security.trusted_proxies') || in_array('*', config('security.trusted_proxies'), true)) {
        $errors[] = 'Cloudflare Tunnel 必須設定確切可信代理 IP，不可使用 *。';
    }
    if (! is_file(public_path('build/manifest.json'))) {
        $errors[] = '缺少前端正式編譯產物。';
    }
    if (! config('app.key')) {
        $errors[] = '缺少 APP_KEY。';
    }

    if (Schema::hasTable('users')) {
        $defaultUser = User::query()->where('email', 'console@taigreat.com.tw')->first();
        if ($defaultUser && Hash::check('password', $defaultUser->password)) {
            $errors[] = '管理員仍使用預設密碼，請執行 console:password 更換。';
        }
        if (! User::query()->exists()) {
            $errors[] = '請先以 console:password --create 建立管理員。';
        }
    } else {
        $errors[] = '請先以維護身分執行正式資料庫遷移並建立管理員。';
    }

    foreach ($errors as $error) {
        $this->error($error);
    }
    if ($errors !== []) {
        return 1;
    }
    $this->info('應用程式上線前檢查通過；仍需驗證 Cloudflare、備份及主機設定。');

    return 0;
})->purpose('Check production security prerequisites without displaying secrets');
