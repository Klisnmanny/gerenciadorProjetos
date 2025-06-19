<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Usuario;

class AuthController extends Controller
{
    // Exibe a página de login
    public function showLogin()
    {
        return view('inicio', ['appName' => 'Gerenciador de Projetos']);
    }

    // Processa o login do usuário
    public function processLogin(Request $request)
    {
        // Validação básica (pode ser melhorada)
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // Busca usuário pelo email
        $user = Usuario::where('email', $request->email)->first();

        // Verifica se usuário existe e senha bate com o hash
        if ($user && Hash::check($request->password, $user->password)) {
            //dd('logado');
            Auth::login($user); // Loga o usuário
            //dd('logado');
            $request->session()->regenerate();
            return redirect()->route('dashboard'); // Redireciona para dashboard
        }

        // Caso contrário, volta com erro
        return back()->withErrors(['email' => 'Credenciais inválidas'])->withInput();
    }

    // Realiza logout
    public function logout()
    {
        Auth::logout();
        return redirect()->route('inicio');
    }
}
