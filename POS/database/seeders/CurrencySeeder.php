<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CurrencySeeder extends Seeder
{
    public function run(): void
    {
        DB::table('currency')->insert([
            [
                'currency'      => 'Japanese Yen',
                'currency_code' => 'JPY',
                'currency_icon' => '¥',
                'currency_rate' => 145.5000, // example rate
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
        ]);
    }
}