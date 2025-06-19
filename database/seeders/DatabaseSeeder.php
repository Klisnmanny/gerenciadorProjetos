<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Usuario;
use App\Models\Projeto;
use App\Models\Tarefa;
use App\Models\Checklist;
use App\Models\Comentario;
use App\Models\HistoricoTarefa;
use App\Models\Notificacao;
use App\Models\Anexo;
use App\Models\SolicitacaoPrazo;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        Usuario::factory()->count(15)->create();
        Projeto::factory()->count(10)->create();
        Tarefa::factory()->count(20)->create();
        Checklist::factory()->count(5)->create();
        Comentario::factory()->count(1)->create();
        HistoricoTarefa::factory()->count(5)->create();
        Notificacao::factory()->count(2)->create();
        Anexo::factory()->count(5)->create();
        SolicitacaoPrazo::factory()->count(2)->create();
    }
}
