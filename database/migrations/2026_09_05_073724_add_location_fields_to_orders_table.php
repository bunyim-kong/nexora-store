<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->decimal('latitude', 10, 8)->nullable()->after('address');
            $table->decimal('longitude', 11, 8)->nullable()->after('latitude');
            $table->text('formatted_address')->nullable()->after('longitude');
            $table->text('delivery_instructions')->nullable()->after('formatted_address');
            $table->text('google_maps_link')->nullable()->after('delivery_instructions');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['latitude', 'longitude', 'formatted_address', 'delivery_instructions', 'google_maps_link']);
        });
    }
};