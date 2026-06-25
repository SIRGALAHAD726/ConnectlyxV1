<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TechView Login</title>

    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
</head>

<body>

<div class="bg"></div>

<div class="container">

    <div class="card">

        <!-- LOGO -->
        <div class="logo">
            <div class="logo-icon">TV</div>
            <div>
                <h2>TechView</h2>
                <span>Peru · Social Network</span>
            </div>
        </div>

        <h1>Iniciar sesión</h1>
        <p class="subtitle">Conecta con el ecosistema tech</p>

        <form action="{{ route('login') }}" method="POST">
            @csrf

            <div class="input-group">
                <label>Correo electrónico</label>
                <input name="email" type="text" placeholder="tucorreo@tech.com" required>
            </div>

            <div class="input-group">
                <label>Contraseña</label>
                <input name="password" type="password" placeholder="••••••••" required>
            </div>

            <button type="submit">Ingresar</button>

        </form>

        <div class="divider">o</div>

        <a href="{{ route('register') }}" class="register-btn">
            Crear nueva cuenta
        </a>

    </div>

</div>

</body>
</html>