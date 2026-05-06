<?php

return [

    'default' => env('DB_CONNECTION'),

    'connections' => [
        'mysql' => [
            'driver' => 'mysql',
            'url' => '',
            'host' => env('DB_HOST'),
            'port' => env('MYSQL_INTERNAL_PORT'),
            'database' => env('MYSQL_DATABASE'),
            'username' => env('MYSQL_USER'),
            'password' => env('MYSQL_PASSWORD'),
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => [],
        ],
    ],

];
