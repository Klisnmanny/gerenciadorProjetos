<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tarefa extends Model
{
    use HasFactory;

    protected $fillable = ['projeto_id', 'titulo', 'descricao', 'responsavel_id', 'data_termino', 'data_inicio', 'status'];

    public function projeto()
    {
        return $this->belongsTo(Projeto::class);
    }

    public function responsavel()
    {
        return $this->belongsTo(Usuario::class, 'responsavel_id');
    }

    public function checklist()
    {
        return $this->hasMany(Checklist::class);
    }

    public function comentarios()
    {
        return $this->hasMany(Comentario::class);
    }

    public function historico()
    {
        return $this->hasMany(HistoricoTarefa::class);
    }
}
