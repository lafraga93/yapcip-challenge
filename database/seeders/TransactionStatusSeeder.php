<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TransactionStatusSeeder extends Seeder
{
    private string $table = 'transaction_statuses';

    public function run(): void
    {
        DB::table($this->table)->insert([
            'description' => 'pending',
        ]);
        DB::table($this->table)->insert([
            'description' => 'finished',
        ]);
    }
}
