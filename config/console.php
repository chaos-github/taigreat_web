<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Extra console IPs
    |--------------------------------------------------------------------------
    |
    | 後台額外允許的 IP / CIDR。本機與內網網段本來就會放行。
    | 網站在公網時，把公司對外 IP 或 VPN 網段寫進 CONSOLE_ALLOWED_IPS。
    | 逗號分隔，例如 "203.0.113.10,203.0.113.0/24"。
    |
    */

    'allowed_cidrs' => array_values(array_filter(array_map(
        trim(...),
        explode(',', (string) env('CONSOLE_ALLOWED_IPS', '')),
    ))),

];
