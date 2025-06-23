<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Dashboard - {{ $appName ?? 'Gerenciador de Projetos' }}</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <!-- Opcional: dashboard.css para grid/carta específica -->
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>
<body>
    <aside style="background:#1f1f1f; color:white; width:220px; min-height:100vh; float:left; display:flex; flex-direction:column; align-items:center; padding:20px 0;">
        <div class="profile-icon" style="font-size:48px; margin-bottom:20px;">
            <i class="bi bi-person-circle"></i>
        </div>
        <div style="font-weight:bold; margin-bottom:18px;">{{ $usuario->nome }}</div>
        <nav>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn" style="width:160px;">Sair</button>
            </form>
        </nav>
    </aside>

    <main style="margin-left:220px; padding:40px 28px;">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:32px;">
            <h1 style="margin:0;">Olá, {{ $usuario->nome }} 👋</h1>
            <a href="{{ route('projetos.create') }}" class="btn" style="max-width:200px; text-align:center;">+ Criar Projeto</a>
        </div>

        <section>
            <h2 style="margin-bottom:16px;">Seus Projetos</h2>
            <div class="projetos-grid" style="display:flex; flex-wrap:wrap; gap:18px;">
                @forelse ($usuario->projetos as $projeto)
                    <div class="projeto-card" style="background:white; border:1px solid #ccc; border-radius:8px; width:240px; padding:18px 12px; position:relative; display:flex; flex-direction:column; justify-content:space-between; min-height:160px;">
                        <a href="{{ route('projetos.show', $projeto->id) }}" style="color:#007bff; font-weight:bold; font-size:18px; text-decoration:none;">{{ $projeto->nome }}</a>
                        <p style="color:#555; font-size:14px; margin:8px 0 0 0; flex:1; overflow:hidden; text-overflow:ellipsis;">{{ $projeto->descricao }}</p>
                        <div class="projeto-actions" style="position:absolute; top:12px; right:12px;">
                            <form method="POST" action="{{ route('projetos.destroy', $projeto->id) }}" onsubmit="return confirm('Tem certeza que deseja excluir este projeto?');" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" title="Excluir Projeto" style="background:none; border:none; color:#d33; font-size:20px; cursor:pointer;">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <p>Você ainda não criou nenhum projeto.</p>
                @endforelse
            </div>
        </section>

        <section style="margin-top:38px;">
            <h2 style="margin-bottom:16px;">Projetos Associados</h2>
            <div class="projetos-grid" style="display:flex; flex-wrap:wrap; gap:18px;">
                @forelse ($usuario->projetosParticipando as $projeto)
                    <div class="projeto-card" style="background:white; border:1px solid #ccc; border-radius:8px; width:240px; padding:18px 12px; position:relative; display:flex; flex-direction:column; justify-content:space-between; min-height:160px;">
                        <a href="{{ route('projetos.show', $projeto->id) }}" style="color:#007bff; font-weight:bold; font-size:18px; text-decoration:none;">{{ $projeto->nome }}</a>
                        <p style="color:#555; font-size:14px; margin:8px 0 0 0; flex:1; overflow:hidden; text-overflow:ellipsis;">{{ $projeto->descricao }}</p>
                        <div class="projeto-actions" style="position:absolute; top:12px; right:12px;">
                            <form method="POST" action="{{ route('projetos.sair', $projeto->id) }}" onsubmit="return confirm('Deseja sair deste projeto?');" style="display:inline;">
                                @csrf
                                <button type="submit" title="Sair do Projeto" style="background:none; border:none; color:#007bff; font-size:20px; cursor:pointer;">
                                    <i class="bi bi-box-arrow-right"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <p>Você não participa de nenhum projeto ainda.</p>
                @endforelse
            </div>
        </section>
    </main>
</body>
</html>