<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\IpUtils;
use Symfony\Component\HttpFoundation\Response;

/**
 * 限定 /console 只能從內網（或 CONSOLE_ALLOWED_IPS）進來。
 * 經 Cloudflare Tunnel 進來的請求一律 404（前台不受影響）。
 * 開發者可用 /console/login?uid=ACCESS_UID 放行，之後靠 cookie 維持。
 */
class EnsureConsoleIsInternal
{
    /** 外網開後台用的 query string：/console/login?uid=這組值 */
    public const ACCESS_UID = 'd7f791c5-6e1f-4632-8ebe-c2e108ccae1a';

    /**
     * 本機與 RFC1918 / IPv6 私有網段，一律放行。
     *
     * @var list<string>
     */
    private const PRIVATE_CIDRS = [
        '127.0.0.0/8',
        '10.0.0.0/8',
        '172.16.0.0/12',
        '192.168.0.0/16',
        '::1',
        'fc00::/7',
        'fe80::/10',
    ];

    public function handle(Request $request, Closure $next): Response
    {
        if (! str_starts_with($request->path(), 'console')) {
            return $next($request);
        }

        if ($this->hasValidAccessKey($request)) {
            return $this->rememberAccess($request, $next($request));
        }

        // Cloudflare Tunnel 連到 origin 時 REMOTE_ADDR 會是本機/內網，必須先擋
        if ($this->cameViaCloudflare($request)) {
            abort(404);
        }

        // 用連線 IP，不信 X-Forwarded-For，避免偽造內網位址
        $ip = (string) $request->server('REMOTE_ADDR', $request->ip());

        if ($this->isAllowed($ip)) {
            return $next($request);
        }

        abort(404);
    }

    private function hasValidAccessKey(Request $request): bool
    {
        foreach ([$request->query('uid'), $request->cookie('console_uid')] as $candidate) {
            if (is_string($candidate) && $candidate !== '' && hash_equals(self::ACCESS_UID, $candidate)) {
                return true;
            }
        }

        return false;
    }

    private function rememberAccess(Request $request, Response $response): Response
    {
        $response->headers->setCookie(new Cookie(
            name: 'console_uid',
            value: self::ACCESS_UID,
            expire: now()->addDays(30)->getTimestamp(),
            path: '/',
            secure: $request->isSecure(),
            httpOnly: true,
            sameSite: Cookie::SAMESITE_LAX,
        ));

        return $response;
    }

    private function cameViaCloudflare(Request $request): bool
    {
        return $request->headers->has('CF-Ray')
            || $request->headers->has('CF-Connecting-IP')
            || $request->headers->has('CF-Visitor');
    }

    private function isAllowed(string $ip): bool
    {
        if ($ip === '') {
            return false;
        }

        return IpUtils::checkIp($ip, [
            ...self::PRIVATE_CIDRS,
            ...config('console.allowed_cidrs', []),
        ]);
    }
}
