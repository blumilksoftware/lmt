<?php

declare(strict_types=1);

return [
    "default" => env("DB_CONNECTION", "sqlite"),
    "connections" => [
        "sqlite" => [
            "driver" => "sqlite",
            "url" => env("DB_URL"),
            "database" => env("DB_DATABASE", database_path("database.sqlite")),
            "prefix" => "",
            "foreign_key_constraints" => env("DB_FOREIGN_KEYS", true),
            "busy_timeout" => null,
            "journal_mode" => null,
            "synchronous" => null,
        ],
        "pgsql" => [
            "driver" => "pgsql",
            "url" => env("DB_URL"),
            "host" => env("DB_HOST", "127.0.0.1"),
            "port" => env("DB_PORT", "5432"),
            "database" => env("DB_DATABASE", "laravel"),
            "username" => env("DB_USERNAME", "root"),
            "password" => env("DB_PASSWORD", ""),
            "charset" => env("DB_CHARSET", "utf8"),
            "prefix" => "",
            "prefix_indexes" => true,
            "search_path" => "public",
            "sslmode" => "prefer",
        ],
    ],
    "migrations" => [
        "table" => "migrations",
        "update_date_on_publish" => true,
    ],
];
