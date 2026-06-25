<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TechView Peru — Red Social</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>

<body class="bg-gray-100 dark:bg-gray-900 flex flex-col h-screen">

<!-- HEADER -->
<header class="sticky top-0 z-50 bg-white dark:bg-gray-800 shadow border-b border-gray-300 dark:border-gray-700">
    <div class="container mx-auto flex items-center justify-between p-2">

        <div class="flex items-center space-x-2 font-bold text-blue-600">
            TechView
        </div>

        <div class="flex items-center space-x-2">

            <a href="{{ route('logout') }}"
               class="text-blue-600 font-semibold hover:underline">
                Cerrar Sesión
            </a>

            <div class="avatar border border-gray-300 rounded-full p-1">
                <span class="w-10 h-10 flex items-center justify-center font-bold">
                    {{ strtoupper(substr(Auth::user()->name,0,1)) }}
                </span>
            </div>

        </div>

    </div>
</header>

<main class="container mx-auto flex gap-4 p-4 pt-6">

<!-- SIDEBAR IZQUIERDA -->
<aside class="hidden lg:block w-1/4 space-y-4">

    <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow">
        <h3 class="font-bold text-lg">Sugerencias de Amigos</h3>

        <ul class="space-y-2">

            @foreach ($sugerenciasAmigos as $sugerencia)

                <li class="flex items-center justify-between p-2 border rounded-lg">

                    <span>{{ $sugerencia->name }}</span>

                    <form action="{{ route('amigos.enviarSolicitud', $sugerencia->id) }}" method="POST">
                        @csrf
                        <button class="text-blue-600">Añadir</button>
                    </form>

                </li>

            @endforeach

        </ul>
    </div>

</aside>

<!-- CENTRO (FEED TECHVIEW CON TU DISEÑO) -->
<section class="w-full lg:w-1/2 space-y-4">

    <!-- COMPOSER -->
    <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow">

        <h2 class="font-bold">
            Bienvenido, {{ Auth::user()->name }}
        </h2>

        <form action="{{ route('publicaciones.store') }}" method="POST" class="mt-4">
            @csrf

            <textarea
                name="contenido"
                class="w-full border rounded-lg p-2"
                placeholder="¿Qué estás construyendo hoy?"
                required></textarea>

            <button class="mt-2 bg-blue-600 text-white px-4 py-2 rounded-lg">
                Publicar
            </button>

        </form>

    </div>

    <!-- FEED DINÁMICO TECHVIEW -->
    <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow">

        <h2 class="font-bold text-lg mb-4">Publicaciones</h2>

        @foreach ($publicaciones as $publicacion)

            <div class="border p-4 rounded-lg mb-4">

                <div class="flex items-center space-x-2 font-bold">

                    <div class="w-8 h-8 bg-blue-500 text-white rounded-full flex items-center justify-center">
                        {{ strtoupper(substr($publicacion->user->name ?? 'U',0,1)) }}
                    </div>

                    <span>{{ $publicacion->user->name ?? 'Usuario' }}</span>

                    <small class="text-gray-500">
                        {{ $publicacion->created_at->diffForHumans() }}
                    </small>

                </div>

                <p class="mt-2 text-gray-700 dark:text-gray-300">
                    {{ $publicacion->contenido }}
                </p>

            </div>

        @endforeach

    </div>

</section>

<!-- SIDEBAR DERECHA -->
<aside class="hidden xl:block w-1/4 space-y-4">

    <!-- SOLICITUDES -->
    <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow">

        <h3 class="font-bold">Solicitudes de Amistad</h3>

        <ul class="space-y-2">

            @foreach ($solicitudes as $solicitud)

                <li class="flex justify-between items-center">

                    <span>{{ $solicitud->sender->name }}</span>

                    <div class="space-x-2">

                        <form action="{{ route('amigos.aceptarSolicitud', $solicitud->id) }}" method="POST">
                            @csrf
                            <button class="text-blue-600">Aceptar</button>
                        </form>

                        <form action="{{ route('amigos.rechazarSolicitud', $solicitud->id) }}" method="POST">
                            @csrf
                            <button class="text-red-600">Rechazar</button>
                        </form>

                    </div>

                </li>

            @endforeach

        </ul>

    </div>

    <!-- AMIGOS -->
    <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow">

        <h3 class="font-bold">Amigos</h3>

        <ul class="space-y-2">

            @foreach ($amigos as $amigo)

                <li class="flex justify-between items-center p-2 border rounded-lg">

                    <span>{{ $amigo->name }}</span>

                    <div class="space-x-2">

                        <a href="{{ route('chat.show', $amigo->id) }}"
                           class="text-blue-600">
                            Chat
                        </a>

                        <form action="{{ route('amigos.eliminar', $amigo->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="text-red-600">
                                Eliminar
                            </button>
                        </form>

                    </div>

                </li>

            @endforeach

        </ul>

    </div>

</aside>

</main>

<!-- FOOTER -->
<footer class="bg-gray-800 text-white text-center p-4 mt-auto">
    <p>© 2024 TechView Peru</p>
</footer>

</body>
</html>