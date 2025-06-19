<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\ProjetoUsuario;
use App\Models\Projeto;
use App\Models\Usuario;

class ProjetoUsuarioFactory extends Factory
{
    protected $model = ProjetoUsuario::class;

    public function definition()
    {
        return [
            'projeto_id' => Projeto::factory(),
            'usuario_id' => Usuario::factory(),
        ];
    }
}
