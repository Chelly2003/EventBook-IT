<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    Schema::create('events', function (Blueprint $table) {
        $table->id();

        // Who created the event
        $table->unsignedBigInteger('user_id');

        // Event type: "online" or "venue"
        $table->enum('event_type', ['online', 'venue']);

        // Basic info
        $table->string('title');
        $table->text('description');

        // Date & time
        $table->date('event_date');
        $table->time('event_time');

        // Online-only
        $table->string('online_platform')->nullable(); // Zoom, Google Meet etc.
        $table->string('meeting_link')->nullable();
        $table->string('stream_key')->nullable();

        // Venue-only
        $table->string('venue_name')->nullable();
        $table->string('address_line1')->nullable();
        $table->string('address_line2')->nullable();
        $table->string('city')->nullable();
        $table->string('county')->nullable();
        $table->string('country')->nullable();
        $table->string('google_maps_url')->nullable();
        $table->integer('capacity')->nullable();

        // Ticketing
        $table->enum('payment_type', ['free', 'paid']);
        $table->decimal('price', 10, 2)->nullable();
        $table->enum('fee_handling', ['pass', 'absorb'])->default('pass');

        // Banner image
        $table->string('banner')->nullable();

        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
