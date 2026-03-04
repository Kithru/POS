<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {

            $table->bigIncrements('category_id'); // Primary key
            $table->string('category_name')->unique();
            $table->text('description')->nullable();

            $table->timestamp('added_date')->useCurrent(); // automatically set current timestamp
            $table->unsignedBigInteger('added_by')->nullable();

            $table->timestamp('modified_date')->nullable(); // will set on update manually
            $table->unsignedBigInteger('modified_by')->nullable();

            $table->tinyInteger('status')->default(1)->comment('1 = Active, 0 = Inactive');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};