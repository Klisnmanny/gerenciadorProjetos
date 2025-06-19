<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notificacao extends Model
{
    use HasFactory;
    protected $table = 'notificacoes'; // Define o nome correto da tabela no banco


    protected $fillable = ['usuario_id', 'mensagem', 'lida'];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class);
    }
}
