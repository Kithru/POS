<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void{
        Schema::table('order_items', function (Blueprint $table) {

            $table->decimal('final_amount', 10, 2)
                ->default(0)
                ->after('subtotal');

            $table->timestamp('updated_at')
                ->nullable()
                ->after('final_amount');

            $table->tinyInteger('KOD_status')
                ->default(0)
                ->comment('KOD item - 1, Normal item - 0')
                ->after('updated_at');

            $table->string('table_no', 20)
                ->nullable()
                ->after('KOD_status');
        });
    }

    public function down(): void{
        Schema::table('order_items', function (Blueprint $table) {
            $table->dropColumn([
                'final_amount',
                'updated_at',
                'KOD_status',
                'table_no'
            ]);
        });
    }
};
