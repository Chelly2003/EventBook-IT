<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToBookingsTable extends Migration
{
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            // Only add columns if they don't exist
            if (!Schema::hasColumn('bookings', 'user_id')) {
                $table->unsignedBigInteger('user_id')->after('id');
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            }

            if (!Schema::hasColumn('bookings', 'booking_code')) {
                $table->string('booking_code')->unique()->after('event_id');
            }

            if (!Schema::hasColumn('bookings', 'total_amount')) {
                $table->decimal('total_amount', 10, 2)->default(0)->after('booking_code');
            }

            if (!Schema::hasColumn('bookings', 'payment_method')) {
                $table->string('payment_method')->default('mpesa')->after('total_amount');
            }

            if (!Schema::hasColumn('bookings', 'status')) {
                $table->string('status')->default('pending')->after('payment_method');
            }

            if (!Schema::hasColumn('bookings', 'mpesa_checkout_id')) {
                $table->string('mpesa_checkout_id')->nullable()->after('status');
            }

            if (!Schema::hasColumn('bookings', 'mpesa_receipt')) {
                $table->string('mpesa_receipt')->nullable()->after('mpesa_checkout_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            if (Schema::hasColumn('bookings', 'mpesa_receipt')) {
                $table->dropColumn('mpesa_receipt');
            }
            if (Schema::hasColumn('bookings', 'mpesa_checkout_id')) {
                $table->dropColumn('mpesa_checkout_id');
            }
            if (Schema::hasColumn('bookings', 'status')) {
                $table->dropColumn('status');
            }
            if (Schema::hasColumn('bookings', 'payment_method')) {
                $table->dropColumn('payment_method');
            }
            if (Schema::hasColumn('bookings', 'total_amount')) {
                $table->dropColumn('total_amount');
            }
            if (Schema::hasColumn('bookings', 'booking_code')) {
                $table->dropColumn('booking_code');
            }
            if (Schema::hasColumn('bookings', 'user_id')) {
                $table->dropForeign(['user_id']);
                $table->dropColumn('user_id');
            }
        });
    }
}
