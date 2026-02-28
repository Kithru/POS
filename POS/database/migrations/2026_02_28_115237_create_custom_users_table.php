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
        Schema::create('users', function (Blueprint $table) {

            $table->bigIncrements('userid'); // Primary Key

            $table->string('name', 150);
            $table->string('email', 150)->unique();
            $table->string('password');

            $table->timestamp('addeddate')->useCurrent();
            $table->timestamp('modifieddate')->nullable()->useCurrentOnUpdate();

            $table->integer('user_level')->default(1); 
            // Example: 1 = User, 2 = Admin

            $table->boolean('status')->default(1); 
            // 1 = Active, 0 = Inactive
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
