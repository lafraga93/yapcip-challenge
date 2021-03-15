<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

final class TransactionTypes extends Migration
{
    private string $table = 'transaction_types';

    public function up(): void
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->id();
            $table->string('description');
        });
    }

    public function down(): void
    {
        Schema::drop($this->table);
    }
}
