<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Tabela: credit_cards
    // Campos:
    // id: SERIAL PRIMARY KEY
    // user_id: INT REFERENCES users(id)
    // card_name: VARCHAR(100)
    // limit: DECIMAL(10, 2) (limite do cartão)
    // available_limit: DECIMAL(10, 2) (limite disponível)
    // created_at: TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    // updated_at: TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    public function up(): void
    {
        Schema::create('credit_cards', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');

            $table->string('name',70);
            $table->string('owner_name',70);
            $table->float('limit',10,2);
            $table->float('avaliable_limit',10,2);
            $table->string('number');
            $table->string('due_month');
            $table->string('due_year');
            $table->string('security_code');
            $table->softDeletes();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('credit_cards');
    }
};
