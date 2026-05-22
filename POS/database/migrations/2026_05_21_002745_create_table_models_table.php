<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    
public function up(): void {
        Schema::create('tables', function (Blueprint $table) {

            $table->id();
            $table->string('table_number')->unique();

            // Availability
            // 0 = Available
            // 1 = Not Available
            $table->tinyInteger('availability')
                  ->default(0)
                  ->comment('0 = Available, 1 = Not Available');

            // Table Status
            // 1 = Active
            // 0 = Inactive
            $table->tinyInteger('table_status')
                  ->default(1)
                  ->comment('1 = Active, 0 = Inactive');
            $table->integer('max_pax');
            $table->integer('min_pax');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('tables');
    }

};
