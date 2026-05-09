<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up(): void
{
    Schema::table('bookings', function (Blueprint $table) {
        $table->integer('quantity')->default(1)->after('payment_method');
        $table->string('heard_from')->nullable()->after('quantity');
    });
}

public function down(): void
{
    Schema::table('bookings', function (Blueprint $table) {
        $table->dropColumn(['quantity', 'heard_from']);
    });
}
};
