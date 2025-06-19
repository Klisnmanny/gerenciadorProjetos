<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Anexo;
use App\Models\Tarefa;
use App\Models\Usuario;

class AnexoFactory extends Factory
{
    protected $model = Anexo::class;

    public function definition()
    {
        return [
            'tarefa_id' => Tarefa::factory(),
            'usuario_id' => Usuario::factory(),
            'nome_arquivo' => $this->faker->word() . ".pdf",
            'url' => $this->faker->url(),
        ];
    }
}
