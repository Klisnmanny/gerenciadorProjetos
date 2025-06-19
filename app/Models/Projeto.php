<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Projeto extends Model
{
    use HasFactory;

    protected $fillable = ['nome', 'descricao', 'criador_id'];

    public function criador()
    {
        return $this->belongsTo(Usuario::class, 'criador_id');
    }

    public function tarefas()
    {
        return $this->hasMany(Tarefa::class);
    }

    public function membros()
    {
        return $this->belongsToMany(Usuario::class, 'projeto_usuarios');
    }
}
