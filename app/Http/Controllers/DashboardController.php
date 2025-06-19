<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
{
    //dd(Auth::check());
    $usuario = Auth::user();

    if (!$usuario) {
        return redirect()->route('inicio');
    }

    
    return view('dashboard', compact('usuario'));
}

}
