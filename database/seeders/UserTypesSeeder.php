<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserTypesSeeder extends Seeder
{
    private string $table = 'user_types';

    public function run(): void
    {
        DB::table($this->table)->insert([
            [
                'slug' => 'common',
            ],
            [
                'slug' => 'shopkeeper',
            ],
        ]);
    }
}
