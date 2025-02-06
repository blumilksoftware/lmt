<?php

declare(strict_types=1);

return [
    "custom" => [
        "consent" => [
            "required" => "Zgoda na przetwarzanie danych jest wymagana",
            "accepted" => "Zgoda na przetwarzanie danych jest wymagana",
        ],
        "email" => [
            "email" => "Niepoprawny adres e-mail",
            "required" => "Email jest wymagany",
        ],
        "name" => [
            "required" => "Imię jest wymagane",
            "min" => "Imię musi mieć co najmniej 2 znaki",
            "max" => "Imię może mieć maksymalnie 50 znaków",
        ],
        "surname" => [
            "required" => "Nazwisko jest wymagane",
            "min" => "Nazwisko musi mieć co najmniej 2 znaki",
            "max" => "Nazwisko może mieć maksymalnie 50 znaków",
        ],
        "company" => [
            "max" => "Firma może mieć maksymalnie 50 znaków",
        ],
    ],
];
