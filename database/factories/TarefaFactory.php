<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Tarefa;
use App\Models\Projeto;
use App\Models\Usuario;

class TarefaFactory extends Factory
{
    protected $model = Tarefa::class;

    public function definition()
    {
        return [
            'projeto_id' => Projeto::factory(),
            'titulo' => $this->faker->sentence(),
            'descricao' => $this->faker->paragraph(),
            'responsavel_id' => Usuario::factory(),
            'data_termino' => $this->faker->date(),
            'data_inicio' => $this->faker->optional()->dateTime(),
            'status' => $this->faker->randomElement(['A Fazer', 'Realizando', 'Montagem', 'Realizado']),
        ];
    }
}
