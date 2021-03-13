<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TransactionTypeSeeder extends Seeder
{
    private string $table = 'transaction_types';

    public function run(): void
    {
        DB::table($this->table)->insert([
            'description' => 'payment',
        ]);
        DB::table($this->table)->insert([
            'description' => 'reversal',
        ]);
    }
}
