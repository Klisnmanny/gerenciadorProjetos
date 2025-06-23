<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $appName }} - Login</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <div class="auth-container">
        <h1>{{ $appName }}</h1>
        @if ($errors->any())
            <div class="error-message">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <label for="email">E-mail:</label>
            <input type="email" name="email" required autofocus autocomplete="email">

            <label for="password">Senha:</label>
            <input type="password" name="password" required autocomplete="current-password">

            <button type="submit">Entrar</button>
        </form>

        <a href="{{ route('register') }}" class="link-secondary">
            Ainda não tem acesso? Crie seu acesso
        </a>
    </div>
</body>
</html>