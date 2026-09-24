<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\IpUtils;
use Symfony\Component\HttpFoundation\Response;

class EnsureConsoleIsInternal
{
    /**
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

        $ip = (string) $request->server('REMOTE_ADDR', $request->ip());

        if ($this->isAllowed($ip)) {
            return $next($request);
        }

        abort(404);
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
