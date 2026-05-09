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

}

public function down(): void
{
    Schema::table('tickets', function (Blueprint $table) {

        // Drop the FK again if migration is rolled back
        $table->dropForeign(['event_id']);
    });
}

};
