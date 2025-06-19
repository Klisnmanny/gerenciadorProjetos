<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Comentario;
use App\Models\Tarefa;
use App\Models\Usuario;

class ComentarioFactory extends Factory
{
    protected $model = Comentario::class;

    public function definition()
    {
        return [
            'tarefa_id' => Tarefa::factory(),
            'usuario_id' => Usuario::factory(),
            'texto' => $this->faker->paragraph(),
        ];
    }
}

