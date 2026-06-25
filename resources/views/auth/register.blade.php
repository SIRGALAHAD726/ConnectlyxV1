<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Create a New Account</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    @keyframes logoAnimation {
      0% { transform: translateX(-50%) scale(1); }
      50% { transform: translateX(0%) scale(1.1); }
      100% { transform: translateX(-50%) scale(1); }
    }
    .animated-logo {
      animation: logoAnimation 2s ease-in-out infinite;
    }
  </style>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col justify-center items-center p-4">


  <div class="w-full max-w-md bg-white p-6 rounded-lg shadow-lg">
    <h1 class="text-2xl font-bold text-center">Create a New Account</h1>
    <p class="text-center text-gray-600 mb-4">It's quick and easy.</p>

    <form action="{{ route('register') }}" method="POST">
      @csrf
      <div class="space-y-4">
        <div class="space-y-2">
          <label for="name" class="block text-sm font-medium text-gray-700">Nombre completo</label>
          <input id="name" name="name" placeholder="Ingrese su nombre completo" required class="w-full px-4 py-2 border rounded-md" />
        </div>

        <div class="space-y-2">
          <label for="email" class="block text-sm font-medium text-gray-700">Correo Electrónico</label>
          <input id="email" name="email" type="email" placeholder="Correo Electrónico" required class="w-full px-4 py-2 border rounded-md" />
        </div>

        <div class="space-y-2">
          <label for="password" class="block text-sm font-medium text-gray-700">Contraseña</label>
          <input id="password" name="password" type="password" placeholder="Cree una contraseña" required class="w-full px-4 py-2 border rounded-md" />
        </div>

        <div class="space-y-2">
          <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirmar Contraseña</label>
          <input id="password_confirmation" name="password_confirmation" type="password" placeholder="Confirme su contraseña" required class="w-full px-4 py-2 border rounded-md" />
        </div>

        <button type="submit" class="w-full px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Registrarse</button>
      </div>
    </form>
  </div>
</body>
</html>
