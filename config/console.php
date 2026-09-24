<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Extra console IPs
    |--------------------------------------------------------------------------
    |
    | Private LAN ranges and localhost are always allowed. Add office public
    | IPs or VPN CIDRs here when the site is hosted on the public internet.
    | Comma-separated, e.g. "203.0.113.10,203.0.113.0/24".
    |
    */

    'allowed_cidrs' => array_values(array_filter(array_map(
        trim(...),
        explode(',', (string) env('CONSOLE_ALLOWED_IPS', '')),
    ))),

];
