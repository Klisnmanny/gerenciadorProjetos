<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $appName }} - Login</title>
    <link rel="stylesheet" href="{{ asset('css/inicio.css') }}">
</head>
<body>
    <div class="login-container">
        <h1 class="app-name">{{ $appName }}</h1>

        {{-- Exibe erros, se houver --}}
        @if ($errors->any())
            <div class="error-message">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        {{-- Formulário de login --}}
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <label for="email">E-mail:</label>
            <input type="email" name="email" required>

            <label for="password">Senha:</label>
            <input type="password" name="password" required>

            <button type="submit">Entrar</button>

            <p class="register-link">
                Ainda não tem acesso? <a href="{{ route('register') }}">Crie seu acesso</a>

            </p>
        </form>
    </div>
</body>
</html>
