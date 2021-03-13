<?php

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

            $table->decimal('balance')->default(0.00);
            $table->foreignId('user_id')->constrained();

            $table->dateTime('created_at')->useCurrent();
            $table->dateTime('updated_at')->nullable()->useCurrentOnUpdate();
        });
    }
}
