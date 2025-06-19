<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Criar Projeto - {{ $appName }}</title>
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
<style>
  .user-lists {
    display: flex;
    gap: 30px;
    max-width: 700px;
    margin: auto;
  }
  .list-container {
    flex: 1;
  }
  h3 {
    text-align: center;
  }
  select {
    width: 100%;
    height: 300px;
  }
  button {
    margin-top: 10px;
    width: 100%;
    padding: 8px;
    cursor: pointer;
  }
</style>
</head>
<body>
<main style="padding: 40px;">
    <h1>Criar Novo Projeto</h1>

    @if ($errors->any())
        <div class="error-message" style="color: red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('projetos.store') }}" id="formProjeto">
        @csrf

        <label for="nome">Nome do Projeto:</label><br />
        <input type="text" name="nome" id="nome" required /><br /><br />

        <label for="descricao">Descrição:</label><br />
        <textarea name="descricao" id="descricao" rows="4"></textarea><br /><br />

        <div class="user-lists" aria-label="Seleção de usuários para o projeto">
            <div class="list-container">
                <h3>Usuários Disponíveis</h3>
                <select id="usuariosDisponiveis" multiple aria-label="Usuários disponíveis para adicionar">
                    @foreach ($usuarios as $usuario)
                        <option value="{{ $usuario->id }}">{{ $usuario->nome }} ({{ $usuario->email }})</option>
                    @endforeach
                </select>
                <button type="button" id="btnAdd" aria-controls="usuariosSelecionados" aria-label="Adicionar usuários selecionados">Adicionar →</button>
            </div>

            <div class="list-container">
                <h3>Usuários Selecionados</h3>
                <select id="usuariosSelecionados" name="usuarios[]" multiple aria-label="Usuários selecionados para o projeto">
                    {{-- Inicialmente vazio, será preenchido ao adicionar --}}
                </select>
                <button type="button" id="btnRemove" aria-controls="usuariosDisponiveis" aria-label="Remover usuários selecionados">← Remover</button>
            </div>
        </div>

        <br />
        <button type="submit">Criar Projeto</button>
    </form>

    <br />
    <a href="{{ route('dashboard') }}">← Voltar ao Dashboard</a>

</main>

<script>
    const btnAdd = document.getElementById('btnAdd');
    const btnRemove = document.getElementById('btnRemove');
    const usuariosDisponiveis = document.getElementById('usuariosDisponiveis');
    const usuariosSelecionados = document.getElementById('usuariosSelecionados');

    btnAdd.addEventListener('click', () => {
        moveSelectedOptions(usuariosDisponiveis, usuariosSelecionados);
    });

    btnRemove.addEventListener('click', () => {
        moveSelectedOptions(usuariosSelecionados, usuariosDisponiveis);
    });

    function moveSelectedOptions(fromSelect, toSelect) {
        const selectedOptions = Array.from(fromSelect.selectedOptions);
        selectedOptions.forEach(option => {
            fromSelect.removeChild(option);
            toSelect.appendChild(option);
        });
    }
</script>
</body>
</html>
