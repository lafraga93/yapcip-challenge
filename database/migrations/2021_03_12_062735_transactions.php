<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

final class Transactions extends Migration
{
    private string $table = 'transactions';

    public function up(): void
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->id();
            $table->decimal('value');
            $table->foreignId('payer_id')->constrained('users');
            $table->foreignId('payee_id')->constrained('users');
            $table->foreignId('transaction_type_id')->constrained();
            $table->dateTime('created_at')->useCurrent();
        });
    }
}
