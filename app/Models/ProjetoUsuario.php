<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjetoUsuario extends Model
{
    use HasFactory;

    protected $fillable = ['projeto_id', 'usuario_id'];

    public function projeto()
    {
        return $this->belongsTo(Projeto::class);
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class);
    }
}
