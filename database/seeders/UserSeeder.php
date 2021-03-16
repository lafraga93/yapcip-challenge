<?php

declare(strict_types=1);

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
            $isOdd = $this->isOdd();
            $randomData = [
                'document' => $isOdd ? $faker->numerify('##############') : $faker->numerify('###########'),
                'type' => $isOdd ? 2 : 1,
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
                'balance' => 100,
            ]);
        }
    }

    private function isOdd(): bool
    {
        return rand(0, 9) % 2 !== 0 ? true : false;
    }
}
