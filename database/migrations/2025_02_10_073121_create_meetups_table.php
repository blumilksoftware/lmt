<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    public function up(): void
    {
        Schema::create("meetups", function (Blueprint $table): void {
            $table->id();
            $table->string("title");
            $table->string("slug")->unique();
            $table->string("place");
            $table->string("localization");
            $table->string("fb_event");
            $table->string("photographers")->nullable();
            $table->boolean("active");

            $table->dateTime("date");
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists("meetups");
    }
};
