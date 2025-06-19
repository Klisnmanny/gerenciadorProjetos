<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Projeto;
use App\Models\Usuario;
use Illuminate\Support\Facades\Auth;

class ProjetoController extends Controller
{
    // Mostrar detalhes do projeto
    public function show($id)
    {
        $projeto = Projeto::findOrFail($id);
        return view('projetos.show', compact('projeto'));
    }

    // Formulário para criar projeto
    public function create()
    {
        // Pega todos os usuários para selecionar os participantes
        //$usuarios = Usuario::all();
        $usuarios = Usuario::where('id', '!=', Auth::id())->get();

        return view('projetos.criar', [
            'appName' => 'Gerenciador de Projetos',
            'usuarios' => $usuarios
        ]);
    }

    // Armazenar novo projeto
    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'nullable|string|max:1000',
            'usuarios' => 'nullable|array',
            'usuarios.*' => 'exists:usuarios,id',
        ]);

        // Cria o projeto e define o criador
        $projeto = new Projeto();
        $projeto->nome = $request->nome;
        $projeto->descricao = $request->descricao;
        $projeto->criador_id = Auth::id();
        $projeto->save();

        // Vincula usuários selecionados ao projeto, se houver
        if ($request->has('usuarios')) {
            $usuariosIds = $request->usuarios;
            // garante que o criador está entre os usuários também
            if (!in_array(Auth::id(), $usuariosIds)) {
                $usuariosIds[] = Auth::id();
            }
            $projeto->membros()->sync($usuariosIds);
        } else {
            $projeto->membros()->sync([Auth::id()]);
        }


        return redirect()->route('dashboard')->with('sucesso', 'Projeto criado com sucesso!');
    }

    public function destroy($id)
        {
            $projeto = Projeto::findOrFail($id);

            if ($projeto->criador_id !== Auth::id()) {
                abort(403);
            }

            $projeto->delete();
            return redirect()->route('dashboard')->with('sucesso', 'Projeto excluído.');
        }

    public function sair($id)
        {
            $projeto = Projeto::findOrFail($id);
            $projeto->membros()->detach(Auth::id());

            return redirect()->route('dashboard')->with('sucesso', 'Você saiu do projeto.');
        }

}
