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
         Schema::create('tickets', function (Blueprint $table) {
            $table->id();

            // Link to event
            $table->foreignId('event_id')
                  ->constrained('events')
                  ->onDelete('cascade');

            // Link to attendee
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->onDelete('cascade');

            // Unique ticket code that will be in QR
            $table->string('ticket_code')->unique();

            // For tracking if scanned/verified
            $table->boolean('is_used')->default(false);

            // Optional – timestamp when scanned
            $table->timestamp('used_at')->nullable();

            // Ticket type (optional: Regular, VIP)
            $table->string('ticket_type')->default('regular');

            // Ticket price (in case events have multiple ticket types)
            $table->decimal('price', 10, 2);

            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};

