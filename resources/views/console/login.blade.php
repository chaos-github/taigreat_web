<!DOCTYPE html>
<html lang="zh-Hant-TW">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>登入內容中心 | 泰權興貿易</title>
    <link rel="icon" href="{{ asset('assets/taigreat/images/favicon.svg') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@400;500;600&family=Noto+Sans+TC:wght@300;400;500;700&display=swap" rel="stylesheet">
    @vite(['resources/css/console.css', 'resources/js/console.js'])
</head>
<body class="console-login">
    <div class="login-shell">
        <section class="login-brand">
            <p class="login-kicker">Taigreat Console</p>
            <a class="login-logo" href="{{ route('home') }}">
                <img class="brand-logo brand-logo--light" src="{{ asset('assets/taigreat/images/tgc-logo-ink.png') }}" alt="恆展堂建築 TAIGREAT CONSTRUCTION">
            </a>
            <h1>管理官網顯示的內容</h1>
            <p>登入後可編輯工程實績、最新消息與產品服務，變更會同步出現在前台頁面。</p>
        </section>

        <section class="login-panel">
            <div class="login-card">
                <p class="login-card__eyebrow">Sign in</p>
                <h2>登入內容中心</h2>

                @if ($errors->any())
                    <div class="console-alert console-alert--error" role="alert">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form method="post" action="{{ route('console.login.store') }}" class="login-form">
                    @csrf
                    <label>
                        <span>電子信箱</span>
                        <input type="email" name="email" value="{{ old('email') }}" autocomplete="username" required autofocus>
                    </label>
                    <label>
                        <span>密碼</span>
                        <input type="password" name="password" autocomplete="current-password" required>
                    </label>
                    <label class="login-remember">
                        <input type="checkbox" name="remember" value="1">
                        <span>保持登入</span>
                    </label>
                    <button type="submit">進入內容中心</button>
                </form>
            </div>
        </section>
    </div>
</body>
</html>
