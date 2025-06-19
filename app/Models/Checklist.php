<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Checklist extends Model
{
    use HasFactory;
    protected $table = 'checklist';

    protected $fillable = ['tarefa_id', 'usuario_id', 'descricao', 'concluido'];

    public function tarefa()
    {
        return $this->belongsTo(Tarefa::class);
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class);
    }
}
