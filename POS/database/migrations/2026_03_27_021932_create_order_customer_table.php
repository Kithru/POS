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
        Schema::create('order_customer', function (Blueprint $table) {
            $table->id('order_customer_id'); // Primary key
            $table->unsignedBigInteger('order_id');
            $table->string('order_code')->unique();

            // Customer Details
            $table->string('customer_first_name');
            $table->string('customer_last_name');
            $table->string('customer_email');
            $table->string('customer_phone');
            $table->string('postal_code');
            $table->string('perfecture');
            $table->string('city');
            $table->string('street_name');
            $table->string('apartment_no')->nullable();

            // Delivery Details
            $table->string('receiver_first_name');
            $table->string('receiver_last_name');
            $table->string('receiver_email');
            $table->string('receiver_phone');
            $table->string('receiver_postal_code');
            $table->string('receiver_prefecture');
            $table->string('receiver_city');
            $table->string('receiver_street_name');
            $table->string('receiver_apartment_no')->nullable();

            $table->timestamp('added_date')->useCurrent();
            $table->timestamp('modified_date')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_customer');
    }
};