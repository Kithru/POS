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
        Schema::create('items', function (Blueprint $table) {

            $table->id('item_id');
            $table->string('item_name');
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('subcategory_id');
            $table->text('description')->nullable();
            $table->string('item_code')->unique();
            $table->string('currency');
            $table->decimal('price',10,2);
            $table->integer('quantity');
            $table->boolean('countable')->default(1);
            $table->tinyInteger('status')->default(1)->comment('1 = Active, 0 = Deactive'); 
            $table->string('image')->nullable();
            $table->timestamp('added_date');
            $table->integer('added_by');

            $table->timestamp('modified_date')->nullable();
            $table->integer('modified_by')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
