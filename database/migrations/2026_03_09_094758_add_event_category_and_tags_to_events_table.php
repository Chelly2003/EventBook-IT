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
        Schema::table('events', function (Blueprint $table) {
            // Add after 'description' (adjust ->after() if you prefer different position)
            $table->string('event_category')->nullable()->after('description')
                ->comment('Main category: arts, business, concert, workshops, etc.');

            $table->json('tags')->nullable()->after('event_category')
                ->comment('Array of additional tags, e.g. ["seminar", "networking"]');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn(['event_category', 'tags']);
        });
    }
};
