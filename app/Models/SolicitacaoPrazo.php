<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SolicitacaoPrazo extends Model
{
    use HasFactory;
    protected $table = 'solicitacoes_prazo'; // Nome correto da tabela no banco


    protected $fillable = ['tarefa_id', 'usuario_id', 'nova_data_termino', 'status'];

    public function tarefa()
    {
        return $this->belongsTo(Tarefa::class);
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class);
    }
}

