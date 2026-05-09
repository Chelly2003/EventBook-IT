<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('social_clicks', function (Blueprint $table) {
            $table->id();

            // platform clicked (facebook, instagram, tiktok, whatsapp, youtube, etc.)
            $table->string('platform');

            // optional: track which user clicked (if logged in)
            $table->unsignedBigInteger('user_id')->nullable();

            // track where the click happened (homepage, property page, dashboard, etc.)
            $table->string('location')->nullable();

            // optional: store the actual URL that was clicked
            $table->string('url')->nullable();

            // for analytics
            $table->ipAddress('ip_address')->nullable();
            $table->string('device')->nullable(); // mobile, desktop, tablet

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('social_clicks');
    }
};
