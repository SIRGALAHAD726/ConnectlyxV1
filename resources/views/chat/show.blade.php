<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat Interface</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .scrollable {
            max-height: calc(100vh - 160px);
            overflow-y: auto;
        }
    </style>
</head>

<body class="bg-gray-100">

    <div class="flex h-screen flex-col">
        <div class="flex flex-1">
            <div class="p-4 border-b border-gray-200 flex justify-between items-center border-gray-200">
                <div class="p-4 border-b border-gray-200">
                    <div class="flex justify-between items-center">
                        <h1 class="text-2xl font-bold text-gray-800">Chats</h1>
                    </div>
                </div>
                

                

                <div class="scrollable">
                    <ul>
                        @foreach ($amigos as $amigoItem)
                            <li class="p-4 flex items-center space-x-4 hover:bg-gray-200 border border-gray-300 rounded-lg">
{{--                                 <img src="https://via.placeholder.com/40" alt="{{ $amigoItem->name }}"
                                    class="w-10 h-10 rounded-full"> --}}
                                <div class="flex-1 text-left">
                                    <h2 class="font-semibold text-gray-800 inline">{{ $amigoItem->name }}</h2>
                                    <div class="flex space-x-2">
                                        <a href="{{ route('chat.show', $amigoItem->id) }}"
                                            class="text-blue-500 hover:underline">Chatear</a>
                                        <form action="{{ route('amigos.eliminar', $amigoItem->id) }}" method="POST"
                                            style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:underline">Eliminar</button>
                                        </form>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
                
                
            </div>

            <div class="flex-1 flex flex-col">  
                <div class="p-4 border-b border-gray-200 flex justify-between items-center bg-blue-500">
                    <div class="flex items-center space-x-4">
{{--                         <img src="https://via.placeholder.com/40" alt="{{ $amigo->name }}"
                            class="w-10 h-10 rounded-full"> --}}
                        <h2 class="font-semibold text-white">Chat con {{ $amigo->name }}</h2>
                    </div>
                    <nav class="flex space-x-2">
                        <a href="{{ route('perfil') }}" class="text-gray-200 hover:text-gray-300">Perfil</a>
                        <a href="{{ route('logout') }}" class="text-red-600 hover:underline">Cerrar Sesión</a>
                    </nav>
                </div>

                <div class="scrollable p-4 flex-1 bg-gray-200">
                    @foreach ($messages as $message)
                        <div
                            class="{{ $message->sender_id === Auth::id() ? 'flex justify-end' : 'flex justify-start' }} mb-4">
                            @if ($message->sender_id !== Auth::id())
{{--                                 <img src="https://via.placeholder.com/40" alt="{{ $amigo->name }}"
                                    class="w-10 h-10 rounded-full mr-2"> --}}
                            @endif
                            <div
                                class="{{ $message->sender_id === Auth::id() ? 'bg-blue-500 text-white' : 'bg-gray-200 text-gray-900' }} rounded-lg py-2 px-4 max-w-xs">
                                <strong>{{ $message->sender_id === Auth::id() ? 'Tú' : $amigo->name }}:</strong>
                                {{ $message->content }}
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="p-4 border-t border-gray-200 bg-gray-200">
                    <form action="{{ route('messages.store', $amigo->id) }}" method="POST"
                        class="flex items-center space-x-2">
                        @csrf
                        <input type="hidden" name="receiver_id" value="{{ $amigo->id }}">
                        <textarea name="content" placeholder="Escribe un mensaje" required class="flex-1 p-2 border rounded-md"></textarea>
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">
                            Enviar
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
