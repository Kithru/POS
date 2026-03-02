<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('subcategories', function (Blueprint $table) {
            $table->id('subcategory_id'); // Primary Key
            $table->unsignedBigInteger('category_id'); 
            $table->string('subcategory_name');
            $table->text('description')->nullable();
            $table->date('added_date');
            $table->date('modified_date');
            $table->tinyInteger('status')->default(1)->comment('1 = Active, 0 = Inactive'); // Status column
            $table->timestamps(); 

            // Foreign key constraint
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subcategories');
    }
};