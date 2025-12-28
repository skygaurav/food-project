<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dish_reactions', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('dish_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('type');
            $table->timestamps();
            $table->unique(['dish_id', 'user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dish_reactions');
    }
};
