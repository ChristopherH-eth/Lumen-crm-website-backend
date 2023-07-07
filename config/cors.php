<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure your settings for handling CORS requests. This
    | configuration determines how your application responds to CORS requests.
    |
    */

    'paths' => ['*'],

    /*
    |--------------------------------------------------------------------------
    | Allowed HTTP Methods
    |--------------------------------------------------------------------------
    |
    | The HTTP methods that are allowed for CORS requests. If you are using
    | the built-in Laravel middleware, you'll need to specify the methods
    | here in order to respond to preflight requests properly.
    |
    */

    'allowed_methods' => ['POST', 'GET', 'OPTIONS', 'PUT', 'DELETE'],

    'allowed_origins' => ['http://localhost:3000', 'http://localhost'],

    'allowed_origins_patterns' => [],

    /*
    |--------------------------------------------------------------------------
    | Allowed HTTP Headers
    |--------------------------------------------------------------------------
    |
    | The HTTP headers that are allowed for CORS requests. If you are using
    | the built-in Laravel middleware, you'll need to specify the headers
    | here in order to respond to preflight requests properly.
    |
    */

    'allowed_headers' => ['Content-Type', 'Authorization', 'X-Requested-With'],

    /*
    |--------------------------------------------------------------------------
    | Allowed HTTP Headers
    |--------------------------------------------------------------------------
    |
    | The HTTP headers that are allowed to be exposed for CORS responses.
    | You may add additional headers to this array if needed.
    |
    */

    'exposed_headers' => [],

    /*
    |--------------------------------------------------------------------------
    | CORS Max Age
    |--------------------------------------------------------------------------
    |
    | The number of seconds the CORS response may be cached by the browser.
    | If you are using the built-in Laravel middleware, this value will
    | automatically be sent as the Access-Control-Max-Age response header.
    |
    */

    'max_age' => 86400,

    /*
    |--------------------------------------------------------------------------
    | CORS Support Credentials
    |--------------------------------------------------------------------------
    |
    | Determines if the server should allow credentials for CORS requests.
    | If you are using the built-in Laravel middleware, this value will
    | automatically be sent as the Access-Control-Allow-Credentials
    | response header.
    |
    */

    'supports_credentials' => true,

];
