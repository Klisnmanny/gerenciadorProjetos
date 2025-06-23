<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
            Schema::table('tarefas', function (Blueprint $table) {
            $table->foreignId('criador_id')
            ->nullable()
            ->after('id')
            ->constrained('usuarios')
            ->onDelete('cascade');
    });
    }

    public function down()
    {
        Schema::table('tarefas', function (Blueprint $table) {
            $table->dropForeign(['criador_id']);
            $table->dropColumn('criador_id');
        });
    }
};