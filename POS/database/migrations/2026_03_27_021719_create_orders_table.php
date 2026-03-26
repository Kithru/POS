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
            
            $table->string('status')->default('0')->comment('Order status: pending=0, confirmed=1, prepared=2, hand over=3, cancelled=4');
            $table->text('notes')->nullable();
            $table->decimal('total_amount', 10, 2);
            $table->decimal('discount', 10, 2)->default(0);
            $table->decimal('tax', 10, 2)->default(0);
            $table->timestamp('added_date')->useCurrent();
            $table->timestamp('confirmed_date')->nullable();
            $table->timestamp('prepared_date')->nullable();
            $table->timestamp('hand_over_date')->nullable();
            $table->timestamp('modified_date')->useCurrent()->useCurrentOnUpdate();
            $table->unsignedBigInteger('modified_by')->nullable();
            $table->timestamp('cancelled_date')->nullable();
            $table->unsignedBigInteger('cancelled_by')->nullable();
            $table->text('cancelled_reason')->nullable();
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
