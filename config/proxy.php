<?php

return [

    /**
     * The endpoint you want to proxy to
     */
    'base_url' => env('PROXY_BASE_URL'),

    /**
     * Basic auth credentials to send to the proxied endpoint
     */
    'auth' => [
        'username' => env('PROXY_AUTH_USERNAME'),
        'password' => env('PROXY_AUTH_PASSWORD')
    ]

];
