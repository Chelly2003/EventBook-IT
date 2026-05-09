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
    Schema::table('booking_items', function (Blueprint $table) {
        $table->string('heard_from')->nullable()->after('subtotal');
    });
}

public function down(): void
{
    Schema::table('booking_items', function (Blueprint $table) {
        $table->dropColumn('heard_from');
    });
}
};
