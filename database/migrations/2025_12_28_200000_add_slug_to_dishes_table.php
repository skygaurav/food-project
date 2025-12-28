<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('dishes', function (Blueprint $table): void {
            $table->string('slug')->unique()->nullable()->after('name');
        });
    }

    public function down(): void
    {
        Schema::table('dishes', function (Blueprint $table): void {
            $table->dropColumn('slug');
        });
    }
};
