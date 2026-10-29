<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bank_transactions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('from_account_id')
                ->constrained('bank_accounts')
                ->restrictOnDelete();

            $table->foreignId('to_account_id')
                ->constrained('bank_accounts')
                ->restrictOnDelete();

            $table->decimal('amount', 15, 2);

            $table->string('status', 20)->default('completed');

            $table->uuid('reference')->unique();

            $table->timestamps();

            $table->index(['from_account_id', 'created_at']);
            $table->index(['to_account_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bank_transactions');
    }
};