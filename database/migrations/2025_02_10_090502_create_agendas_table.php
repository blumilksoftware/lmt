<?php

declare(strict_types=1);

use Blumilksoftware\Lmt\Models\Meetup;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    public function up(): void
    {
        Schema::create("agendas", function (Blueprint $table): void {
            $table->id();

            $table->string("title");
            $table->string("speaker")->nullable();
            $table->text("description")->nullable();
            $table->string("start");
            $table->integer("order_column")->nullable();

            $table->foreignIdFor(Meetup::class)->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists("agendas");
    }
};
