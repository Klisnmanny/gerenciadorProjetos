<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Notificacao;
use App\Models\Usuario;

class NotificacaoFactory extends Factory
{
    protected $model = Notificacao::class;

    public function definition()
    {
        return [
            'usuario_id' => Usuario::factory(),
            'mensagem' => $this->faker->sentence(),
            'lida' => $this->faker->boolean(),
        ];
    }
}
