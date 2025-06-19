<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Projeto;
use App\Models\Usuario;

class ProjetoFactory extends Factory
{
    protected $model = Projeto::class;

    public function definition()
    {
        return [
            'nome' => $this->faker->sentence(3),
            'descricao' => $this->faker->paragraph(),
            'criador_id' => Usuario::factory(),
        ];
    }
}

