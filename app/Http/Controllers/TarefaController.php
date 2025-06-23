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

    public function aceitar($id)
            {
                $tarefa = Tarefa::findOrFail($id);

                // Apenas o responsável pode aceitar
                if (auth()->id() !== $tarefa->responsavel_id) {
                    return redirect()->back()->withErrors('Você não tem permissão para aceitar esta tarefa.');
                }

                $tarefa->status = 'Realizando';
                $tarefa->data_inicio = now();
                $tarefa->save();

                return redirect()->back()->with('sucesso', 'Tarefa aceita e movida para Realizando!');
            }


    public function show($id)
            {
                $tarefa = \App\Models\Tarefa::with(['checklist', 'responsavel'])->findOrFail($id);
                return view('tarefas.show', compact('tarefa'));
            }
    
            
    public function marcarComoFeita($id)
            {
                $tarefa = \App\Models\Tarefa::with('checklist')->findOrFail($id);

                // Se a tarefa tem checklist e algum não está concluído, retorna com erro
                if ($tarefa->checklist->count() > 0 && $tarefa->checklist->where('concluido', false)->count() > 0) {
                    return redirect()->back()->with('erro', 'Falta terminar checklist');
                }

                $tarefa->status = 'Realizado';
                $tarefa->save();

                return redirect()->back()->with('sucesso', 'Tarefa marcada como realizada!');
            }       
}
