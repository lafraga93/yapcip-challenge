<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserTypesSeeder::class,
            UserSeeder::class,
            TransactionTypeSeeder::class,
            TransactionStatusSeeder::class,
        ]);
    }
}
