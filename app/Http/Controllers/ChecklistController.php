<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Checklist;
use App\Models\Tarefa;

class ChecklistController extends Controller
{
    // Adiciona um novo item de checklist para uma tarefa
    public function store(Request $request, $tarefaId)
    {
        $request->validate([
            'descricao' => 'required|string|max:255',
        ]);

        Checklist::create([
            'tarefa_id' => $tarefaId,
            'usuario_id' => auth()->id(),
            'descricao' => $request->descricao,
            'concluido' => false,
        ]);

        return redirect()->back()->with('sucesso', 'Checklist criado!');
    }

    // Marca um item do checklist como concluído ou não
    public function update(Request $request, $id)
        {
            $checklist = \App\Models\Checklist::findOrFail($id);
            $checklist->concluido = $request->has('concluido');
            $checklist->save();

            return redirect()->back()->with('sucesso', 'Status do checklist atualizado!');
        }

    // Remove um item do checklist
    public function destroy($id)
    {
        $checklist = Checklist::findOrFail($id);
        $checklist->delete();

        return redirect()->back()->with('sucesso', 'Checklist removido!');
    }
}