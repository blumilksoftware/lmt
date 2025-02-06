<?php

declare(strict_types=1);

use Blumilksoftware\Lmt\Models\Meetup;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    public function up(): void
    {
        Schema::create("companies", function (Blueprint $table): void {
            $table->id();

            $table->string("name")->nullable();
            $table->string("url")->nullable();
            $table->string("type");
            $table->integer("order_column")->nullable();

            $table->foreignIdFor(Meetup::class)->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists("companies");
    }
};
