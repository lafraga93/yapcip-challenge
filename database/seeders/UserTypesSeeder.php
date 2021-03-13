<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserTypesSeeder extends Seeder
{
    private string $table = 'user_types';

    public function run(): void
    {
        DB::table($this->table)->insert([
            'description' => 'common',
        ]);
        DB::table($this->table)->insert([
            'description' => 'shopkeeper',
        ]);
    }
}
