<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // <---------------- Alterado por gemini: Definição da tabela 'eventos'
        Schema::create('eventos', function (Blueprint $table) {
            $table->id();
            
            $table->string('titulo'); // Título do evento
            $table->text('descricao')->nullable(); // Descrição pode ser vazia
            $table->dateTime('data_hora'); // Data e hora do evento
            $table->string('local'); // Localização
            $table->string('palestrante'); // Nome do orador
            
            // Status pré-definidos. 'enum' garante que só entram estes valores.
            $table->enum('status', ['agendada', 'realizada', 'cancelada'])->default('agendada');
            
            $table->timestamps(); // Cria created_at e updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('eventos');
    }
};
