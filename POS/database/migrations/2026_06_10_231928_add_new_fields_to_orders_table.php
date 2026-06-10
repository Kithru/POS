<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void {
        Schema::table('orders', function (Blueprint $table) {

            $table->decimal('final_amount', 10, 2)->nullable()->after('total_amount');

            $table->tinyInteger('order_type')
                ->nullable()
                ->comment('online - 1, Dine in - 2, Take away - 3')
                ->after('final_amount');

            $table->tinyInteger('payment_status')
                ->nullable()
                ->comment('paid - 1, pay_later - 0')
                ->after('order_type');

            $table->dateTime('payment_date')
                ->nullable()
                ->after('payment_status');

            $table->string('table_no', 20)
                ->nullable()
                ->after('cancelled_reason');
        });
    }

    public function down(): void {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'final_amount',
                'order_type',
                'payment_status',
                'payment_date',
                'table_no'
            ]);
        });
    }
};
