<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('model_has_roles', function (Blueprint $table) {
            // Step 1: Drop the existing primary key (PostgreSQL requires this)
            // No arguments = drop whatever PK currently exists
            $table->dropPrimary();

            // Step 2: Now we can safely make team_id nullable
            $table->unsignedBigInteger('team_id')->nullable()->change();

            // Step 3: Add a new primary key that excludes team_id
            // (since you have 'teams' => false, team_id is not needed in PK)
            $table->primary(['role_id', 'model_type', 'model_id']);
        });
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
