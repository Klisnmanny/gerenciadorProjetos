<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\SolicitacaoPrazo;
use App\Models\Tarefa;
use App\Models\Usuario;

class SolicitacaoPrazoFactory extends Factory
{
    protected $model = SolicitacaoPrazo::class;

    public function definition()
    {
        return [
            'tarefa_id' => Tarefa::factory(),
            'usuario_id' => Usuario::factory(),
            'nova_data_termino' => $this->faker->date(),
            'status' => $this->faker->randomElement(['Pendente', 'Aprovado', 'Negado']),
        ];
    }
}
