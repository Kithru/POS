<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up() {
        Schema::create('orders', function (Blueprint $table) {
            $table->id('order_id');
            $table->string('order_code')->unique();
            
            $table->string('customer_name');
            $table->string('customer_email');
            $table->string('customer_phone');
            $table->string('customer_address');

            // Delivery
            $table->string('receiver_name');
            $table->string('receiver_email');
            $table->string('receiver_phone');
            $table->string('receiver_address');
            $table->string('status')->default('0');
            $table->text('notes')->nullable();
            $table->decimal('total_amount', 10, 2);
            $table->timestamp('added_date')->useCurrent();
            $table->timestamp('modified_date')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
