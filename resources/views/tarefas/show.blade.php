<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Tarefa: {{ $tarefa->titulo }}</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        .container { max-width: 600px; margin: 40px auto; }
        .card { box-shadow: 0 2px 8px #0001; padding: 24px; border-radius: 10px; background: #fff; }
        .mb-3 { margin-bottom: 1rem; }
        .btn { padding: .4rem 1rem; border: none; border-radius: 4px; cursor: pointer; }
        .btn-primary { background: #0d6efd; color: #fff; }
        .btn-secondary { background: #6c757d; color: #fff; }
        .btn-success { background: #198754; color: #fff; }
        .btn-danger { background: #dc3545; color: #fff; }
        .badge { display: inline-block; margin-left: 8px; padding: .2em .6em; border-radius: 4px; font-size: .85em; }
        .bg-success { background: #198754; color: #fff; }
        .bg-info { background: #0dcaf0; color: #000; }
        .list-group { list-style: none; padding: 0; margin: 0; }
        .list-group-item { padding: 10px 16px; border-bottom: 1px solid #eee; background: #f9f9f9; border-radius: 6px; margin-bottom: 10px; display: flex; align-items: center; justify-content: space-between; }
        .form-check-input { margin-right: 8px; }
        .actions { display: flex; gap: 10px; align-items: center; }
        form.inline { display: inline; }
        .checklist-label { cursor: pointer; flex: 1; margin-left: 8px; }
    </style>
</head>
<body>
<div class="container">
    <a href="{{ url()->previous() }}" class="btn btn-secondary mb-3"><i class="bi bi-arrow-left"></i> Voltar</a>    
    <div class="card">
        <h2 class="mb-3">{{ $tarefa->titulo }}</h2>
        <p><strong>Autor da tarefa:</strong> {{ $tarefa->criador->nome ?? '-' }}</p>
        <p><strong>Responsável:</strong> {{ $tarefa->responsavel->nome ?? '-' }}</p>
        <p>
            <strong>Data de início:</strong>
            @if($tarefa->data_inicio)
                {{ \Carbon\Carbon::parse($tarefa->data_inicio)->format('d/m/Y H:i') }}
            @else
                -
            @endif
        </p>

        <!-- Botão para abrir formulário de checklist -->
        <button class="btn btn-primary mb-3" id="btnAbrirChecklist"><i class="bi bi-plus-lg"></i> Criar Checklist</button>

        <!-- Formulário de checklist (escondido inicialmente) -->
        <form action="{{ route('checklists.store', $tarefa->id) }}" method="POST" id="formChecklist" style="display: none;">
            @csrf
            <div class="mb-3">
                <input type="text" name="descricao" class="form-control" placeholder="Nome do checklist..." required style="width: 100%; padding: 8px;">
            </div>
            <button type="submit" class="btn btn-success">Adicionar</button>
        </form>

        <hr>
        <h5>Itens do Checklist</h5>
        <ul class="list-group mb-3">
            @forelse($tarefa->checklist as $item)
                <li class="list-group-item">
                    <div class="actions" style="width:100%;">
                        <!-- Form para marcar/desmarcar -->
                        <form action="{{ route('checklists.update', $item->id) }}" method="POST" class="inline" style="flex:1;display:flex;align-items:center;">
                            @csrf
                            @method('PATCH')
                            <input type="checkbox" name="concluido" onchange="this.form.submit()" {{ $item->concluido ? 'checked' : '' }}>
                            <span class="checklist-label">{{ $item->descricao }}</span>
                        </form>
                        @if($item->concluido)
                            <span class="badge bg-success">Concluído</span>
                        @endif
                        <!-- Form para deletar -->
                        <form action="{{ route('checklists.destroy', $item->id) }}" method="POST" class="inline" onsubmit="return confirm('Deseja excluir este item do checklist?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" title="Excluir"><i class="bi bi-trash"></i></button>
                        </form>
                    </div>
                </li>
            @empty
                <li class="list-group-item text-muted">Nenhum item ainda.</li>
            @endforelse
        </ul>
    </div>
</div>
<script>
    document.getElementById('btnAbrirChecklist').onclick = function() {
        document.getElementById('formChecklist').style.display = 'block';
        this.style.display = 'none';
    }
</script>
</body>
</html>