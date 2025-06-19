<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('tarefas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('projeto_id')->constrained('projetos')->onDelete('cascade');
            $table->string('titulo', 255);
            $table->text('descricao')->nullable();
            $table->foreignId('responsavel_id')->nullable()->constrained('usuarios')->onDelete('set null');
            //$table->date('data_termino');
            $table->date('data_termino')->nullable();
            $table->timestamp('data_inicio')->nullable();
            $table->enum('status', ['A Fazer', 'Realizando', 'Montagem', 'Realizado'])->default('A Fazer');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tarefas');
    }
};

