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
                'currency'      => 'US Dollar',
                'currency_code' => 'USD',
                'currency_icon' => '$',
                'currency_rate' => 1.0000, // base rate
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'currency'      => 'Sri Lankan Rupee',
                'currency_code' => 'LKR',
                'currency_icon' => 'Rs',
                'currency_rate' => 360.0000, // example rate
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
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