<?php

declare(strict_types=1);

use Blumilksoftware\Lmt\Models\Meetup;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    public function up(): void
    {
        Schema::create("speakers", function (Blueprint $table): void {
            $table->id();

            $table->string("first_name");
            $table->string("last_name");
            $table->text("description");
            $table->json("companies")->default(json_encode([]));
            $table->string("presentation")->nullable();
            $table->string("video_url")->nullable();
            $table->integer("order_column")->nullable();

            $table->foreignIdFor(Meetup::class)->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists("speakers");
    }
};
