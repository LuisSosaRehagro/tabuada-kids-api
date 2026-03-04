<?php

return [
    'paths'                    => ['api/*'],
    'allowed_methods'          => ['*'],
    'allowed_origins'          => array_unique(array_filter(array_merge(
        explode(',', env('FRONTEND_URL', 'http://localhost:3000')),
        ['https://tabuada-kids-web.vercel.app']
    ))),
    'allowed_origins_patterns' => [],
    'allowed_headers'          => ['*'],
    'exposed_headers'          => [],
    'max_age'                  => 0,
    'supports_credentials'     => true,
];
