<?php

declare(strict_types=1);

use Illuminate\Support\Str;

return [
    "default" => env("CACHE_STORE", "database"),
    "stores" => [
        "array" => [
            "driver" => "array",
            "serialize" => false,
        ],
        "database" => [
            "driver" => "database",
            "connection" => env("DB_CACHE_CONNECTION"),
            "table" => env("DB_CACHE_TABLE", "cache"),
            "lock_connection" => env("DB_CACHE_LOCK_CONNECTION"),
            "lock_table" => env("DB_CACHE_LOCK_TABLE"),
        ],
    ],
    "prefix" => env("CACHE_PREFIX", Str::slug(env("APP_NAME", "laravel"), "_") . "_cache_"),
];
