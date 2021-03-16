<?php

declare(strict_types=1);

namespace Tests\Fixtures;

final class UserData
{
    public static function getData(): object
    {
        return (object) [
            'id' => 1,
            'name' => 'Test',
            'document' => '15965874521',
            'email' => 'test@test.com',
            'password' => 'klfds654s54f8934.kjhdsf45',
            'balance' => 1.50,
            'type' => 'common',
            'user_type_id' => 1,
            'created_at' => '2021-03-16 08:07:57.0',
            'updated_at' => '',
        ];
    }
}
