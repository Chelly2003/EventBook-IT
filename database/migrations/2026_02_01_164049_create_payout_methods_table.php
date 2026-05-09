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
    Schema::create('payout_methods', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade'); // belongs to organiser/user
        $table->string('type')->index(); // 'mpesa', 'paypal', 'bank'

        // M-Pesa specific fields
        $table->string('mpesa_phone')->nullable();
        $table->string('mpesa_shortcode')->nullable();      // Paybill or Till number
        $table->string('mpesa_name')->nullable();           // Business/registered name
        $table->string('mpesa_account_ref')->nullable();    // Optional reference

        // PayPal specific
        $table->string('paypal_email')->nullable();

        // Bank specific (basic — expand later if needed)
        $table->string('bank_account_name')->nullable();
        $table->string('bank_account_number')->nullable();
        $table->string('bank_name')->nullable();
        $table->string('bank_swift')->nullable();

        // Common / status fields
        $table->boolean('is_default')->default(false);
        $table->boolean('is_verified')->default(false);
        $table->timestamps();

        // Optional: unique constraint to prevent duplicate methods of same type
        $table->unique(['user_id', 'type']);
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payout_methods');
    }
};
