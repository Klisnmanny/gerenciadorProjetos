<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('historico_tarefas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tarefa_id')->constrained('tarefas')->onDelete('cascade');
            $table->foreignId('usuario_id')->constrained('usuarios')->onDelete('cascade');
            $table->enum('acao', [
                'Criado', 'Aceito', 'Negado', 'Responsável Alterado', 
                'Checklist Adicionado', 'Checklist Concluído', 
                'Comentário Adicionado', 'Status Alterado', 'Finalizado'
            ]);
            $table->text('detalhes');
            $table->timestamp('data_acao')->default(now());
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('historico_tarefas');
    }
};

