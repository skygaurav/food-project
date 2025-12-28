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
            $table->boolean('reservation')->default(false)->after('website');
            $table->string('phone', 50)->nullable()->after('reservation');
        });
    }

    public function down(): void
    {
        Schema::table('dishes', function (Blueprint $table): void {
            $table->dropColumn(['reservation', 'phone']);
        });
    }
};
