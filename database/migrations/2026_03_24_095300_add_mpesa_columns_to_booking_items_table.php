<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('booking_items', function (Blueprint $table) {
            $table->string('mpesa_checkout_id', 100)->nullable();
            $table->string('mpesa_receipt', 50)->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('booking_items', function (Blueprint $table) {
            $table->dropColumn(['mpesa_checkout_id', 'mpesa_receipt']);
        });
    }
};
