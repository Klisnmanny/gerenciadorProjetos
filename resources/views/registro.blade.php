<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro - Gerenciador de Projetos</title>
    <link rel="stylesheet" href="{{ asset('css/registro.css') }}">
</head>
<body>
    <div class="register-container">
        <h1>Crie seu acesso</h1>

        {{-- Exibe erros, se houver --}}
        @if ($errors->any())
            <div class="error-message">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        {{-- Formulário de registro --}}
        <form method="POST" action="{{ route('register.store') }}">
            @csrf

            <label for="nome">Nome:</label>
            <input type="text" name="nome" required>

            <label for="email">E-mail:</label>
            <input type="email" name="email" required>

            <label for="senha">Senha:</label>
            <input type="password" name="password" required>

            <label for="senha_confirmation">Confirme a senha:</label>
            <input type="password" name="password_confirmation" required>


            <button type="submit">Cadastrar</button>
        </form>

        <p class="login-link">
            Já tem acesso? <a href="{{ route('login') }}">Faça login</a>
        </p>
    </div>
</body>
</html>
