<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Projeto: {{ $projeto->nome }}</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/kanban.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>
<body>
<main>
    <div class="project-header">
        <h1>{{ $projeto->nome }}</h1>
        <div>
            <span class="project-author">
                Autor: {{ $projeto->criador->nome }}
            </span>
            <a href="{{ route('dashboard') }}" class="btn btn-voltar-dashboard">Voltar ao Dashboard</a>
        </div>
    </div>

    @if(session('sucesso'))
        <div class="alert-success">{{ session('sucesso') }}</div>
    @endif

    @if(session('erro'))
        <div class="alert-danger">{{ session('erro') }}</div>
    @endif

    @if($errors->any())
        <div class="error-message">
            <ul>
                @foreach($errors->all() as $erro)
                    <li>{{ $erro }}</li>
                @endforeach
            </ul>
        </div>
    @endif

<div class="kanban-board">
    <!-- MONTAGEM -->
    <div class="kanban-column">
        <div class="kanban-column-header">
            <h2>Montagem</h2>
            @if(auth()->id() === $projeto->criador_id)
                <button class="btn-criar-tarefa" id="abrirModalCriar">+ Criar Tarefa</button>
            @endif
        </div>
        @foreach ($projeto->tarefas->where('status', 'Montagem') as $tarefa)
            <div class="kanban-card">
                <div class="kanban-card-header">
                    <h4>
                        <a href="{{ route('tarefas.show', $tarefa->id) }}">{{ $tarefa->titulo }}</a>
                    </h4>
                    @if ($tarefa->data_termino)
                        <span class="kanban-deadline">
                            <i class="bi bi-calendar"></i> {{ \Carbon\Carbon::parse($tarefa->data_termino)->format('d/m/Y') }}
                        </span>
                    @endif
                </div>
                <div class="kanban-card-body">
                    <p>{{ $tarefa->descricao }}</p>
                    <div class="kanban-meta">
                        <i class="bi bi-person"></i>
                        <strong>Responsável:</strong> {{ $tarefa->responsavel->nome ?? '-' }}
                    </div>
                </div>
                <div class="kanban-actions">
                    @if (auth()->id() === $tarefa->responsavel_id)
                    <form method="POST" action="{{ route('tarefas.aceitar', $tarefa->id) }}">
                        @csrf
                        <button type="submit" class="btn btn-aceitar">Aceitar</button>
                    </form>
                    @endif
                    @if (auth()->id() === $tarefa->criador_id)
                    <form method="POST" action="{{ route('tarefas.destroy', $tarefa->id) }}" onsubmit="return confirm('Confirma exclusão?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-excluir">Excluir</button>
                    </form>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
    <!-- REALIZANDO -->
    <div class="kanban-column">
        <div class="kanban-column-header">
            <h2>Realizando</h2>
        </div>
        @foreach ($projeto->tarefas->where('status', 'Realizando') as $tarefa)
            <div class="kanban-card">
                <div class="kanban-card-header">
                    <h4>
                        <a href="{{ route('tarefas.show', $tarefa->id) }}">{{ $tarefa->titulo }}</a>
                    </h4>
                    @if ($tarefa->data_termino)
                        <span class="kanban-deadline">
                            <i class="bi bi-calendar"></i> {{ \Carbon\Carbon::parse($tarefa->data_termino)->format('d/m/Y') }}
                        </span>
                    @endif
                </div>
                <div class="kanban-card-body">
                    <p>{{ $tarefa->descricao }}</p>
                    <div class="kanban-meta">
                        <i class="bi bi-person"></i>
                        <strong>Responsável:</strong> {{ $tarefa->responsavel->nome ?? '-' }}
                    </div>
                    @if($tarefa->data_inicio)
                        <div class="kanban-data-inicio">
                            <i class="bi bi-play-circle"></i>
                            Iniciada em {{ \Carbon\Carbon::parse($tarefa->data_inicio)->format('d/m/Y H:i') }}
                        </div>
                    @endif
                </div>
                <div class="kanban-actions">
                    @if (auth()->id() === $tarefa->responsavel_id)
                    <form method="POST" action="{{ route('tarefas.feito', $tarefa->id) }}" style="display:inline;">
                        @csrf
                        <button type="submit" class="btn btn-success">Feito</button>
                    </form>
                    @endif
                    @if (auth()->id() === $tarefa->criador_id)
                    <form method="POST" action="{{ route('tarefas.destroy', $tarefa->id) }}" onsubmit="return confirm('Confirma exclusão?');" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-excluir">Excluir</button>
                    </form>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
    <!-- REALIZADO -->
    <div class="kanban-column">
        <div class="kanban-column-header">
            <h2>Realizado</h2>
        </div>
        @foreach ($projeto->tarefas->where('status', 'Realizado') as $tarefa)
            <div class="kanban-card">
                <div class="kanban-card-header">
                    <h4>
                        <a href="{{ route('tarefas.show', $tarefa->id) }}">{{ $tarefa->titulo }}</a>
                    </h4>
                    @if ($tarefa->data_termino)
                        <span class="kanban-deadline">
                            <i class="bi bi-calendar"></i> {{ \Carbon\Carbon::parse($tarefa->data_termino)->format('d/m/Y') }}
                        </span>
                    @endif
                </div>
                <div class="kanban-card-body">
                    <p>{{ $tarefa->descricao }}</p>
                    <div class="kanban-meta">
                        <i class="bi bi-person"></i>
                        <strong>Responsável:</strong> {{ $tarefa->responsavel->nome ?? '-' }}
                    </div>
                </div>
                <div class="kanban-actions">
                    @if (auth()->id() === $tarefa->criador_id)
                    <form method="POST" action="{{ route('tarefas.destroy', $tarefa->id) }}" onsubmit="return confirm('Confirma exclusão?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-excluir">Excluir</button>
                    </form>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</div>

<!-- Modal Criar Tarefa -->
<div class="modal" id="modalCriarTarefa">
    <div class="modal-content">
        <button class="modal-close" id="fecharModal" aria-label="Fechar modal">&times;</button>
        <h2>Criar Nova Tarefa</h2>
        <form method="POST" action="{{ route('tarefas.store', $projeto->id) }}">
            @csrf
            <label for="titulo">Título:</label>
            <input type="text" name="titulo" id="titulo" required value="{{ old('titulo') }}">

            <label for="descricao">Descrição:</label>
            <textarea name="descricao" id="descricao" rows="3">{{ old('descricao') }}</textarea>

            <label for="responsavel_id">Responsável:</label>
            <select name="responsavel_id" id="responsavel_id">
                <option value="">Sem responsável</option>
                @foreach($projeto->membros as $membro)
                    <option value="{{ $membro->id }}" {{ old('responsavel_id')==$membro->id ? 'selected' : '' }}>{{ $membro->nome }}</option>
                @endforeach
            </select>

            <label for="data_termino">Data de Término (opcional):</label>
            <input type="date" name="data_termino" id="data_termino" value="{{ old('data_termino') }}">

            <!-- Remova o campo de status do formulário, sempre cria como "Montagem" -->
            <input type="hidden" name="status" value="Montagem">

            <button type="submit" class="btn">Criar Tarefa</button>
        </form>
    </div>
</div>

<script>
    const modal = document.getElementById('modalCriarTarefa');
    const btnAbrir = document.getElementById('abrirModalCriar');
    const btnFechar = document.getElementById('fecharModal');

    if(btnAbrir) {
        btnAbrir.addEventListener('click', () => {
            modal.classList.add('active');
        });
    }

    btnFechar.addEventListener('click', () => {
        modal.classList.remove('active');
    });

    window.addEventListener('click', (event) => {
        if(event.target === modal) {
            modal.classList.remove('active');
        }
    });

    // Se houver erro de validação ao enviar tarefa, reabrir modal automaticamente
    @if($errors->any() && old('titulo'))
        window.onload = function() {
            document.getElementById('modalCriarTarefa').classList.add('active');
        }
    @endif
</script>
</body>
</html>