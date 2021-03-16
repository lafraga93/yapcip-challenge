<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

final class Notifications extends Migration
{
    private string $table = 'notifications';

    public function up(): void
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->id();
            $table->text('payload');
            $table->dateTime('created_at')->useCurrent();
        });
    }
}
