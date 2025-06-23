<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Criar Projeto - {{ $appName }}</title>
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
<style>
body {
  font-family: 'Segoe UI', Arial, sans-serif;
  background: #f7f9fa;
  color: #222;
  margin: 0;
  padding: 0;
}

main {
  max-width: 700px;
  margin: 40px auto;
  background: #fff;
  border-radius: 10px;
  box-shadow: 0 4px 32px rgba(0,0,0,0.08);
  padding: 40px 32px 32px 32px;
}

h1 {
  text-align: center;
  margin-bottom: 32px;
  font-size: 2rem;
  color: #263159;
  letter-spacing: 1px;
}

label {
  display: block;
  font-weight: 600;
  margin-bottom: 6px;
  color: #263159;
}

input[type="text"], textarea {
  width: 100%;
  border: 1px solid #cdd0d4;
  border-radius: 6px;
  padding: 10px;
  font-size: 1rem;
  background: #fafdff;
  transition: border-color 0.2s;
  margin-bottom: 18px;
}
input[type="text"]:focus, textarea:focus {
  border-color: #6b8cff;
  outline: none;
}

textarea {
  min-height: 80px;
  resize: vertical;
}

.user-lists {
  display: flex;
  gap: 32px;
  justify-content: center;
  margin: 32px 0 0 0;
  flex-wrap: wrap;
}

.list-container {
  flex: 1 1 220px;
  background: #f4f6fa;
  border: 1px solid #e8eaf0;
  border-radius: 8px;
  padding: 18px 12px 14px 12px;
  min-width: 220px;
  max-width: 300px;
  box-sizing: border-box;
  display: flex;
  flex-direction: column;
  align-items: center;
}

h3 {
  text-align: center;
  margin: 0 0 18px 0;
  font-size: 1.1rem;
  color: #3a4767;
  letter-spacing: .5px;
}

select {
  width: 100%;
  height: 220px;
  border-radius: 6px;
  border: 1px solid #d3d6db;
  padding: 8px;
  font-size: .98rem;
  background: #fff;
  margin-bottom: 10px;
  box-sizing: border-box;
}

button, .user-lists button {
  background: linear-gradient(90deg, #6b8cff 0%, #4e66a3 100%);
  color: #fff !important;
  font-weight: 600;
  border: none;
  border-radius: 6px;
  padding: 10px 0;
  cursor: pointer;
  box-shadow: 0 2px 8px rgba(107,140,255,0.08);
  transition: background .2s, box-shadow .2s;
  font-size: 1rem;
  margin-top: 10px;
  width: 100%;
}
button:hover, .user-lists button:hover {
  background: linear-gradient(90deg, #4e66a3 0%, #6b8cff 100%);
  box-shadow: 0 4px 18px rgba(107,140,255,0.13);
}

.error-message {
  color: #b3261e !important;
  background: #fde6e7;
  border: 1px solid #f7b7b7;
  border-radius: 7px;
  padding: 12px 16px;
  margin-bottom: 22px;
  font-size: 1rem;
}

a {
  display: inline-block;
  margin-top: 20px;
  color: #6b8cff;
  text-decoration: none;
  font-weight: 600;
  padding: 4px 8px;
  border-radius: 4px;
  transition: background .2s;
}
a:hover {
  background: #e3eaff;
}

@media (max-width: 780px) {
  main {
    padding: 18px 4vw 24px 4vw;
  }
  .user-lists {
    flex-direction: column;
    gap: 14px;
    align-items: stretch;
  }
  .list-container {
    min-width: 0;
    max-width: none;
    margin-bottom: 10px;
  }
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
        <input type="text" name="nome" id="nome" value="{{ old('nome') }}" required /><br /><br />

        <label for="descricao">Descrição:</label><br />
        <textarea name="descricao" id="descricao" rows="4">{{ old('descricao') }}</textarea><br /><br />

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