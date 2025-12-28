<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('restaurants', function (Blueprint $table): void {
            $table->decimal('meal_cost', 10, 2)->nullable()->after('opening_hours');
            $table->boolean('good_date_spot')->default(false)->after('meal_cost');
        });
    }

    public function down(): void
    {
        Schema::table('restaurants', function (Blueprint $table): void {
            $table->dropColumn(['meal_cost', 'good_date_spot']);
        });
    }
};
