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
        Schema::table('model_has_roles', function (Blueprint $table) {
            // Reverse step 3
            $table->dropPrimary(['role_id', 'model_type', 'model_id']);

            // Reverse step 2
            $table->unsignedBigInteger('team_id')->nullable(false)->change();

            // Reverse step 1 - restore original PK
            $table->primary(['role_id', 'model_type', 'model_id', 'team_id']);
        });
    }
};
