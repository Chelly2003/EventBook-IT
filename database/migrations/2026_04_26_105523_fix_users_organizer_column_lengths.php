<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('role', 10)->change();
            $table->string('organization_name', 10)->nullable()->change();
            $table->string('kra_pin', 10)->nullable()->change();
        });
    }
};
