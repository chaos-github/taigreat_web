<?php

namespace App\Http\Middleware;

use Illuminate\Http\Middleware\TrustProxies;
use Illuminate\Http\Request;

class TrustConfiguredProxies extends TrustProxies
{
    protected $headers = Request::HEADER_X_FORWARDED_FOR
        | Request::HEADER_X_FORWARDED_PORT
        | Request::HEADER_X_FORWARDED_PROTO;

    protected function setTrustedProxyIpAddresses(Request $request): void
    {
        $ips = array_values(array_filter(
            config('security.trusted_proxies', []),
            fn (string $ip): bool => filter_var(explode('/', $ip)[0], FILTER_VALIDATE_IP) !== false,
        ));

        $this->setTrustedProxyIpAddressesToSpecificIps($request, $ips);
    }
}
