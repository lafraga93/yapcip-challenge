<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    private string $table = 'users';
    private string $walletTable = 'wallets';

    public function run(): void
    {
        $faker = \Faker\Factory::create();

        for ($i = 0; $i < 25; $i++) {
            $randomData = [
                'document' => $this->isOdd($i) ? $faker->numerify('##############') : $faker->numerify('###########'),
                'type' => $this->isOdd($i) ? 2 : 1,
            ];

            $insertedId = DB::table($this->table)->insertGetId([
                'name' => $faker->name(),
                'document' => $randomData['document'],
                'email' => $faker->email(),
                'password' => Hash::make('password'),
                'user_type_id' => $randomData['type'],
            ]);

            DB::table($this->walletTable)->insert([
                'user_id' => $insertedId,
            ]);
        }
    }

    private function isOdd(int $i): bool
    {
        return $i % 2 !== 0 ? true : false;
    }
}
