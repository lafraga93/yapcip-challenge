<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TransactionTypeSeeder extends Seeder
{
    private string $table = 'transaction_types';

    public function run(): void
    {
        DB::table($this->table)->insert([
            [
                'slug' => 'transfer',
                'description' => 'Operação de transferência de valores para um destinatário',
            ],
            [
                'slug' => 'rollback',
                'description' => 'Operação de reversão de uma transação',
            ],
        ]);
    }
}
