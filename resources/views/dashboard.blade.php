<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Dashboard - Gerenciador de Projetos</title>
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        .projeto-card {
            background-color: white;
            border: 1px solid #ccc;
            padding: 15px 20px;
            width: 240px;
            border-radius: 8px;
            position: relative;
            transition: 0.3s;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            height: 150px; /* maior altura */
        }
        .projeto-card:hover {
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            transform: scale(1.03);
        }
        .projeto-card a {
            color: #007bff;
            font-weight: bold;
            text-decoration: none;
            flex-grow: 1;
        }
        .projeto-card p {
            margin-top: 40px;
            color: #555;
            font-size: 14px;
            overflow: hidden;
            text-overflow: ellipsis;
            max-height: 3.6em; /* até 3 linhas */
            line-height: 1.2em;
        }
        .projeto-actions {
            position: absolute;
            top: 10px;
            right: 10px;
        }
        .projeto-actions button {
            background: none;
            border: none;
            cursor: pointer;
            color: #888;
            font-size: 18px;
            padding: 0 5px;
        }
        .projeto-actions button:hover {
            color: #d33;
        }
    </style>
</head>
<body>
    <aside>
        <div class="profile-icon text-center">
            <i class="bi bi-person-circle"></i>
        </div>
        <nav>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit">Sair</button>
            </form>
        </nav>
    </aside>

    <main>
        <div class="top-bar">
            <h1>Olá, {{ $usuario->nome }} 👋</h1>
            <a href="{{ route('projetos.create') }}" class="btn-criar">+ Criar Projeto</a>
        </div>

        <div class="meus-projetos">
            <h2 class="section-title">Seus Projetos</h2>
            <div class="projetos-grid">
                @forelse ($usuario->projetos as $projeto)
                    <div class="projeto-card">
                        <a href="{{ route('projetos.show', $projeto->id) }}">
                            <h3>{{ $projeto->nome }}</h3>
                            <p>{{ $projeto->descricao }}</p>
                        </a>

                        <div class="projeto-actions">
                            <form method="POST" action="{{ route('projetos.destroy', $projeto->id) }}" onsubmit="return confirm('Tem certeza que deseja excluir este projeto?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" title="Excluir Projeto">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <p>Você ainda não criou nenhum projeto.</p>
                @endforelse
            </div>
        </div>

        <div class="projetos-associados">
            <h2 class="section-title">Projetos Associados</h2>
            <div class="projetos-grid">
                @forelse ($usuario->projetosParticipando as $projeto)
                    <div class="projeto-card">
                        <a href="{{ route('projetos.show', $projeto->id) }}">
                            <h3>{{ $projeto->nome }}</h3>
                            <p>{{ $projeto->descricao }}</p>
                        </a>

                        <div class="projeto-actions">
                            <form method="POST" action="{{ route('projetos.sair', $projeto->id) }}" onsubmit="return confirm('Deseja sair deste projeto?');">
                                @csrf
                                <button type="submit" title="Sair do Projeto">
                                    <i class="bi bi-box-arrow-right"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <p>Você não participa de nenhum projeto ainda.</p>
                @endforelse
            </div>
        </div>
    </main>
</body>
</html>
