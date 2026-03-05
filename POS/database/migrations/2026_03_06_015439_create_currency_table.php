<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('currency', function (Blueprint $table) {
            $table->id(); // id (auto-increment primary key)
            $table->string('currency'); // currency name, e.g., "US Dollar"
            $table->string('currency_code', 10); // e.g., "USD", "LKR"
            $table->string('currency_icon', 10);
            $table->decimal('currency_rate', 15, 4); // e.g., 1.0000
            $table->timestamps(); // created_at & updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('currency');
    }
};
