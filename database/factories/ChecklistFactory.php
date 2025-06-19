<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Checklist;
use App\Models\Tarefa;
use App\Models\Usuario;

class ChecklistFactory extends Factory
{
    protected $model = Checklist::class;

    public function definition()
    {
        return [
            'tarefa_id' => Tarefa::factory(),
            'usuario_id' => Usuario::factory(),
            'descricao' => $this->faker->sentence(),
            'concluido' => $this->faker->boolean(),
        ];
    }
}

