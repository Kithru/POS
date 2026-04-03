<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(){
        Schema::table('orders', function (Blueprint $table) {
            $table->decimal('cod_amount', 10, 2)
                  ->default(0)
                  ->after('tax'); // ✅ after tax column
        });
    }

    public function down(){
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('cod_amount');
        });
    }
};
