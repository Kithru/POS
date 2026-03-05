<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Call your individual seeders here
        $this->call([
            CurrencySeeder::class,
            UsersTableSeeder::class,
            // ItemSeeder::class,
        ]);
    }
}