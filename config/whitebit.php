<?php

declare(strict_types=1);

use Illuminate\Support\Env;

return [
    'public_key' => Env::get('WHITEBIT_PUBLIC_KEY'),
    'secret_key' => Env::get('WHITEBIT_SECRET_KEY'),
    'timeout' => Env::get('WHITEBIT_SDK_HTTP_TIMEOUT', 60),
    'base_url' => Env::get('WHITEBIT_SDK_BASE_URL', 'https://whitebit.com'),
];
