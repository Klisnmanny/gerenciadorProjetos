<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('solicitacoes_prazo', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tarefa_id')->constrained('tarefas')->onDelete('cascade');
            $table->foreignId('usuario_id')->constrained('usuarios')->onDelete('cascade');
            $table->date('nova_data_termino');
            $table->enum('status', ['Pendente', 'Aprovado', 'Negado'])->default('Pendente');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('solicitacoes_prazo');
    }
};
