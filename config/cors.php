<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    |
    | Aqui configuramos quem pode acessar sua API. Como você removeu o prefixo
    | 'api' das rotas, alteramos o 'paths' para '*' para cobrir todas as URLs
    | como /usuarios/login, /usuarios/logout, etc.
    |
    */


    'paths' => ['*', 'sanctum/csrf-cookie'],


    'allowed_methods' => ['*'],


    'allowed_origins' => ['*'],

    'allowed_origins_patterns' => [],


    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => false,

];
