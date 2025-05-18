<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    // user_id BIGINT UNSIGNED NOT NULL,                    -- ID do usuário que receberá a notificação
    // title VARCHAR(255) NOT NULL,                         -- Título da notificação
    // message TEXT NOT NULL,                               -- Mensagem completa da notificação
    // type ENUM('info', 'warning', 'success', 'error')     -- Tipo de notificação (opcional)
    //     DEFAULT 'info',                                  -- Pode ajudar na formatação visual da notificação
    // link VARCHAR(255),                                   -- Link associado (ex: detalhes da notificação)
    // is_read BOOLEAN DEFAULT FALSE,                       -- Status de leitura da notificação
    // sent_at TIMESTAMP NULL DEFAULT NULL,  
    public function up(): void
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');

            $table->string('title',255);
            $table->string('message');
            $table->enum('type',['info', 'warning', 'success', 'error'])->default('info');
            $table->string('url');
            $table->boolean('is_read')->default(false);
            $table->dateTime('sent_at');
            $table->dateTime('read_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
