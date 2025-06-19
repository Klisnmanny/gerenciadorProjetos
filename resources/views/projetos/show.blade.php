<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Projeto: {{ $projeto->nome }}</title>
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
<style>
  body {
    font-family: Arial, sans-serif;
    margin: 0; padding: 0;
  }
  main {
    padding: 20px;
  }
  h1 {
    margin-bottom: 20px;
  }
  .project-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
  }
  .project-author {
    font-style: italic;
    color: #555;
  }
  .colunas {
    display: flex;
    gap: 20px;
  }
  .coluna {
    background: #f4f4f4;
    padding: 15px;
    flex: 1;
    border-radius: 8px;
    min-height: 400px;
    display: flex;
    flex-direction: column;
  }
  .coluna h2 {
    margin-top: 0;
    margin-bottom: 15px;
    font-size: 18px;
    display: flex;
    justify-content: space-between;
    align-items: center;
  }
  .btn-criar-tarefa {
    padding: 6px 12px;
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 14px;
  }
  .tarefa-card {
    background: white;
    border: 1px solid #ddd;
    padding: 10px;
    border-radius: 6px;
    margin-bottom: 10px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
  }
  .tarefa-card h4 {
    margin: 0 0 5px 0;
  }
  .tarefa-card p {
    margin: 3px 0;
  }
  .tarefa-actions {
    margin-top: 8px;
    display: flex;
    gap: 8px;
  }
  .tarefa-actions form button {
    cursor: pointer;
    padding: 4px 8px;
    border: none;
    border-radius: 4px;
    font-size: 13px;
  }
  .btn-aceitar {
    background-color: #28a745;
    color: white;
  }
  .btn-excluir {
    background-color: #dc3545;
    color: white;
  }
  /* Modal simples */
  .modal {
    display: none;
    position: fixed;
    z-index: 10;
    left: 0; top: 0;
    width: 100%; height: 100%;
    background: rgba(0,0,0,0.5);
    justify-content: center;
    align-items: center;
  }
  .modal.active {
    display: flex;
  }
  .modal-content {
    background: white;
    padding: 20px;
    border-radius: 8px;
    width: 90%;
    max-width: 400px;
  }
  .modal-content label {
    display: block;
    margin-top: 10px;
  }
  .modal-content input, .modal-content textarea, .modal-content select {
    width: 100%;
    margin-top: 5px;
    padding: 6px;
  }
  .modal-content button {
    margin-top: 15px;
    padding: 10px;
    background: #007bff;
    color: white;
    border: none;
    border-radius: 6px;
    cursor: pointer;
  }
  .modal-close {
    float: right;
    cursor: pointer;
    font-weight: bold;
    font-size: 18px;
  }
</style>
</head>
<body>
<main>
  <div class="project-header">
    <h1>{{ $projeto->nome }}</h1>
    <div class="project-author">
      Autor: {{ $projeto->criador->nome }}
    </div>
  </div>

  <div class="colunas">

    <!-- Planejamento -->
    <div class="coluna" id="planejamento">
      <h2>
        Planejamento
        <button class="btn-criar-tarefa" id="abrirModalCriar">+ Criar Tarefa</button>
      </h2>

      @foreach ($projeto->tarefas->where('status', 'planejamento') as $tarefa)
        <div class="tarefa-card">
          <h4>{{ $tarefa->titulo }}</h4>
          <p>{{ $tarefa->descricao }}</p>
          <p><strong>Responsável:</strong> {{ $tarefa->responsavel->nome }}</p>
          @if ($tarefa->data_termino)
            <p><strong>Prazo:</strong> {{ \Carbon\Carbon::parse($tarefa->data_termino)->format('d/m/Y') }}</p>
          @endif

          <div class="tarefa-actions">
            @if (auth()->id() === $tarefa->responsavel_id)
              <form method="POST" action="{{ route('tarefas.aceitar', $tarefa->id) }}">
                @csrf
                <button type="submit" class="btn-aceitar">Aceitar</button>
              </form>
            @endif

            @if (auth()->id() === $tarefa->responsavel_id)
              <form method="POST" action="{{ route('tarefas.destroy', $tarefa->id) }}" onsubmit="return confirm('Confirma exclusão?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-excluir">Excluir</button>
              </form>
            @endif
          </div>
        </div>
      @endforeach
    </div>

    <!-- Realizando -->
    <div class="coluna" id="realizando">
      <h2>Realizando</h2>
      @foreach ($projeto->tarefas->where('status', 'montagem') as $tarefa)
        <div class="tarefa-card">
          <h4>{{ $tarefa->titulo }}</h4>
          <p>{{ $tarefa->descricao }}</p>
          <p><strong>Responsável:</strong> {{ $tarefa->responsavel->nome }}</p>
          @if ($tarefa->data_termino)
            <p><strong>Prazo:</strong> {{ \Carbon\Carbon::parse($tarefa->data_termino)->format('d/m/Y') }}</p>
          @endif
        </div>
      @endforeach
    </div>

    <!-- Pronto -->
    <div class="coluna" id="pronto">
      <h2>Pronto</h2>
      @foreach ($projeto->tarefas->where('status', 'pronto') as $tarefa)
        <div class="tarefa-card">
          <h4>{{ $tarefa->titulo }}</h4>
          <p>{{ $tarefa->descricao }}</p>
          <p><strong>Responsável:</strong> {{ $tarefa->responsavel->nome }}</p>
          @if ($tarefa->data_termino)
            <p><strong>Prazo:</strong> {{ \Carbon\Carbon::parse($tarefa->data_termino)->format('d/m/Y') }}</p>
          @endif
        </div>
      @endforeach
    </div>

  </div>
</main>

<!-- Modal Criar Tarefa -->
<div class="modal" id="modalCriarTarefa">
  <div class="modal-content">
    <span class="modal-close" id="fecharModal">&times;</span>
    <h2>Criar Nova Tarefa</h2>

    <form method="POST" action="{{ route('tarefas.store', $projeto->id) }}">
      @csrf
      <label for="titulo">Título:</label>
      <input type="text" name="titulo" id="titulo" required>

      <label for="descricao">Descrição:</label>
      <textarea name="descricao" id="descricao" rows="3"></textarea>

      <label for="responsavel_id">Responsável:</label>
      <select name="responsavel_id" id="responsavel_id" required>
        @foreach($projeto->membros as $membro)
          <option value="{{ $membro->id }}">{{ $membro->nome }}</option>
        @endforeach
      </select>

      <label for="data_termino">Data de Término (opcional):</label>
      <input type="date" name="data_termino" id="data_termino">

      <input type="hidden" name="status" value="montagem" />


      <button type="submit">Criar Tarefa</button>
    </form>
  </div>
</div>

<script>
  const modal = document.getElementById('modalCriarTarefa');
  const btnAbrir = document.getElementById('abrirModalCriar');
  const btnFechar = document.getElementById('fecharModal');

  btnAbrir.addEventListener('click', () => {
    modal.classList.add('active');
  });

  btnFechar.addEventListener('click', () => {
    modal.classList.remove('active');
  });

  window.addEventListener('click', (event) => {
    if(event.target === modal) {
      modal.classList.remove('active');
    }
  });
</script>

</body>
</html>
