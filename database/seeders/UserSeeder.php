<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    private string $table = 'users';

    public function run(): void
    {
        $faker = \Faker\Factory::create();

        for ($i = 0; $i < 25; $i++) {
            $isOddIndex = $this->isOdd($i);
            $randomData = [
                'document' => $isOddIndex ? $faker->numerify('##############') : $faker->numerify('###########'),
                'type' => $isOddIndex ? 2 : 1,
            ];

            DB::table($this->table)->insert([
                'name' => $faker->name(),
                'document' => $randomData['document'],
                'email' => $faker->email(),
                'password' => Hash::make('password'),
                'user_type_id' => $randomData['type'],
            ]);
        }
    }

    private function isOdd(int $i): bool
    {
        return $i % 2 !== 0 ? true : false;
    }
}
