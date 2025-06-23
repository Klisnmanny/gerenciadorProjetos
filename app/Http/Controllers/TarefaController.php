<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tarefa;

class TarefaController extends Controller
{
     public function store(Request $request, $projetoId)
            {
                $request->validate([
                    'titulo' => 'required|string|max:255',
                    'descricao' => 'nullable|string',
                    'status' => 'required|in:A Fazer,Realizando,Montagem,Realizado',
                    'data_termino' => 'nullable|date',
                    'responsavel_id' => 'nullable|exists:usuarios,id',
                ]);

                $tarefa = new Tarefa();
                $tarefa->titulo = $request->titulo;
                $tarefa->descricao = $request->descricao;
                $tarefa->status = $request->status;
                $tarefa->projeto_id = $projetoId;
                $tarefa->data_termino = $request->data_termino ?? null;
                $tarefa->responsavel_id = $request->responsavel_id ?? null;
                $tarefa->criador_id = auth()->id(); // <-- ADICIONE ESTA LINHA
                $tarefa->save();

                return redirect()->route('projetos.show', $projetoId)
                                ->with('sucesso', 'Tarefa criada com sucesso!');
            }
}
