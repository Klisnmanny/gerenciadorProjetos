<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anexo extends Model
{
    use HasFactory;

    protected $fillable = ['tarefa_id', 'usuario_id', 'nome_arquivo', 'url'];

    public function tarefa()
    {
        return $this->belongsTo(Tarefa::class);
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class);
    }
}
