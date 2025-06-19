<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Usuario extends Authenticatable
{
    use HasFactory;

    protected $fillable = ['nome', 'email', 'password', 'is_admin'];
    protected $hidden = ['password'];

    public function projetos()
    {
        return $this->hasMany(Projeto::class, 'criador_id');
    }

    public function tarefas()
    {
        return $this->hasMany(Tarefa::class, 'responsavel_id');
    }

   // public function projetosParticipando(){return $this->belongsToMany(Projeto::class, 'projeto_usuarios');}


    public function projetosParticipando()
{
    return $this->belongsToMany(Projeto::class, 'projeto_usuarios')
        ->where('criador_id', '!=', $this->id);
}
}
