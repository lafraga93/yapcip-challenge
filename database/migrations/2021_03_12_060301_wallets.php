<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

final class Wallets extends Migration
{
    private string $table = 'wallets';

    public function up(): void
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->id();
            $table->decimal('balance')->default(0);
            $table->foreignId('user_id')->constrained();
            $table->dateTime('updated_at')->nullable()->useCurrentOnUpdate();
        });
    }
}
