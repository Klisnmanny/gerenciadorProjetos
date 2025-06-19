<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\HistoricoTarefa;
use App\Models\Tarefa;
use App\Models\Usuario;

class HistoricoTarefaFactory extends Factory
{
    protected $model = HistoricoTarefa::class;

    public function definition()
    {
        return [
            'tarefa_id' => Tarefa::factory(),
            'usuario_id' => Usuario::factory(),
            'acao' => $this->faker->randomElement([
                'Criado', 'Aceito', 'Negado', 'Responsável Alterado', 
                'Checklist Adicionado', 'Checklist Concluído', 
                'Comentário Adicionado', 'Status Alterado', 'Finalizado'
            ]),
            'detalhes' => $this->faker->paragraph(),
            'data_acao' => $this->faker->dateTime(),
        ];
    }
}
