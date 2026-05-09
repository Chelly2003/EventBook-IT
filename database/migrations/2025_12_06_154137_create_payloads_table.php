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
       Schema::create('payloads', function (Blueprint $table) {
            $table->id();

            // Source of the payload (e.g. 'mpesa', 'stripe', 'booking', etc.)
            $table->string('source')->nullable();

            // Reference ID from provider (transaction ID, booking ID, request ID, etc.)
            $table->string('reference_id')->nullable();

            // Store **entire raw JSON** safely
            $table->json('payload');

            // Optional status field for processing logic
            $table->enum('status', ['received', 'processed', 'failed'])
                  ->default('received');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payloads');
    }
};

