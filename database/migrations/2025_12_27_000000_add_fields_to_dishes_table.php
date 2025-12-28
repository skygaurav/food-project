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
            $table->decimal('meal_cost', 8, 2)->nullable()->after('comment');
            $table->boolean('good_date_spot')->default(false)->after('meal_cost');
            $table->string('website')->nullable()->after('good_date_spot');
        });
    }

    public function down(): void
    {
        Schema::table('dishes', function (Blueprint $table): void {
            $table->dropColumn(['meal_cost', 'good_date_spot', 'website']);
        });
    }
};
