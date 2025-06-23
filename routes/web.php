<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProjetoController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\TarefaController;
use App\Http\Controllers\ChecklistController;



/*
|--------------------------------------------------------------------------
| Rotas públicas
|--------------------------------------------------------------------------
*/

// Página inicial (formulário de login)
Route::get('/', [AuthController::class, 'showLogin'])->name('inicio');

// Redirecionamento GET /login para a página inicial
Route::get('/login', function () {
    return redirect()->route('inicio');
});

// Processa o login
Route::post('/login', [AuthController::class, 'processLogin'])->name('login');

// Página de registro
Route::get('/register', [RegisterController::class, 'show'])->name('register');
Route::post('/register', [RegisterController::class, 'store'])->name('register.store');

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Rotas protegidas (autenticado)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Projetos
    Route::get('/projetos/criar', [ProjetoController::class, 'create'])->name('projetos.create');
    Route::post('/projetos', [ProjetoController::class, 'store'])->name('projetos.store');
    Route::get('/projetos/{id}', [ProjetoController::class, 'show'])->name('projetos.show');
    Route::delete('/projetos/{id}', [ProjetoController::class, 'destroy'])->name('projetos.destroy');
    Route::post('/projetos/{id}/sair', [ProjetoController::class, 'sair'])->name('projetos.sair');

    // Tarefas
    Route::get('/projetos/{projeto}/tarefas/criar', [TarefaController::class, 'create'])->name('tarefas.create');
    Route::post('/projetos/{projeto}/tarefas', [TarefaController::class, 'store'])->name('tarefas.store');
    Route::post('/tarefas/{tarefa}/aceitar', [TarefaController::class, 'aceitar'])->name('tarefas.aceitar');
    Route::delete('/tarefas/{tarefa}', [TarefaController::class, 'destroy'])->name('tarefas.destroy');
    Route::post('/projetos/{id}/tarefas', [TarefaController::class, 'store'])->name('tarefas.store');


    Route::get('/tarefas/{id}', [TarefaController::class, 'show'])->name('tarefas.show');

    Route::post('/tarefas/{tarefa}/checklists', [ChecklistController::class, 'store'])->name('checklists.store');
    Route::patch('/checklists/{id}', [ChecklistController::class, 'update'])->name('checklists.update');
    
    Route::delete('/checklists/{id}', [ChecklistController::class, 'destroy'])->name('checklists.destroy');

    Route::post('/tarefas/{tarefa}/feito', [TarefaController::class, 'marcarComoFeita'])->name('tarefas.feito');

});




