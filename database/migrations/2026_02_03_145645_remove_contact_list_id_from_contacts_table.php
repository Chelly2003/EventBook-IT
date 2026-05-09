<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('contacts', function (Blueprint $table) {
            $table->dropForeign(['contact_list_id']); // drop foreign key first
            $table->dropColumn('contact_list_id');    // then drop the column
        });
    }

    public function down(): void
    {
        Schema::table('contacts', function (Blueprint $table) {
            $table->foreignId('contact_list_id')->constrained()->onDelete('cascade');
        });
    }
};
