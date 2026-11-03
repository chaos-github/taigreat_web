<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\IpUtils;
use Symfony\Component\HttpFoundation\Response;

/** Public Cloudflare traffic cannot use the local content console. */
class EnsureConsoleIsInternal
{
    private const PRIVATE_CIDRS = [
        '10.0.0.0/8', '172.16.0.0/12', '192.168.0.0/16', 'fc00::/7', 'fe80::/10',
    ];

    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->is('console', 'console/*')) {
            return $next($request);
        }

        if ($request->headers->has('CF-Ray')
            || $request->headers->has('CF-Connecting-IP')
            || $request->headers->has('CF-Visitor')) {
            abort(404);
        }

        $ip = (string) $request->server('REMOTE_ADDR', '');
        $allowed = ['127.0.0.0/8', '::1', ...config('console.allowed_cidrs', [])];

        if (config('console.allow_private_networks')) {
            $allowed = [...$allowed, ...self::PRIVATE_CIDRS];
        }

        abort_unless($ip !== '' && IpUtils::checkIp($ip, $allowed), 404);

        return $next($request);
    }
}
