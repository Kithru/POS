<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('items', function (Blueprint $table) {

            $table->id('item_id');
            $table->string('item_name');
            $table->string('currency_type',10);
            $table->text('description')->nullable();
            $table->decimal('price',10,2);
            $table->integer('quantity');
            $table->boolean('countable')->default(1);

            $table->timestamp('added_date');
            $table->integer('added_by');

            $table->timestamp('modified_date')->nullable();
            $table->integer('modified_by')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};