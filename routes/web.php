<?php

declare(strict_types=1);

use Blumilksoftware\Lmt\Http\Controllers\MeetupController;
use Blumilksoftware\Lmt\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;

Route::get("/", WelcomeController::class)->name("welcome");
Route::get("/meetups/{meetup}", MeetupController::class)->name("meetups.show");
