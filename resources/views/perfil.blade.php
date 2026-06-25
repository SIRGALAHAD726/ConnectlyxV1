<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>TechView Peru — Red Social</title>

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Exo+2:wght@300;400;600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

  <!-- Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/dist/tabler-icons.min.css">

  <!-- 🔥 TU DISEÑO ORIGINAL -->
  <link rel="stylesheet" href="{{ asset('css/inicio.css') }}">
</head>

<body>

<!-- ═════════ HEADER (DINÁMICO SOLO LOGIN + LINKS) ═════════ -->
<header>
  <div class="header-inner">

    <a href="{{ url('/') }}" class="logo">
      <div class="logo-icon">
        <i class="ti ti-circuit-board"></i>
      </div>
      <div>
        <span class="logo-text">Tech<span>View</span></span>
        <span class="logo-sub">Peru · Social Network</span>
      </div>
    </a>

    <div class="header-search">
      <i class="ti ti-search"></i>
      <input type="search" placeholder="Buscar publicaciones...">
    </div>

    <nav>
      <a href="{{ url('/home') }}" class="active">
        <i class="ti ti-home"></i><span>Inicio</span>
      </a>

      <a href="{{ url('/amigos') }}">
        <i class="ti ti-users"></i><span>Amigos</span>
      </a>

      <a href="{{ url('/chat') }}">
        <i class="ti ti-message-circle"></i><span>Chat</span>
      </a>

      <a href="{{ route('logout') }}">
        <i class="ti ti-logout"></i><span>Salir</span>
      </a>

      <div class="avatar">
        {{ strtoupper(substr(Auth::user()->name,0,2)) }}
      </div>
    </nav>

  </div>
</header>

<!-- ═════════ HERO (SE MANTIENE IGUAL) ═════════ -->
<div class="hero">
  <div class="hero-eyebrow">
    <i class="ti ti-satellite"></i>
    Conecta · Crea · Crece
  </div>

  <h1>
    La red profesional<br>
    del ecosistema tech peruano
  </h1>

  <p>
    Conecta con developers, diseñadores y emprendedores de tecnología.
  </p>
</div>

<!-- ═════════ CONTENIDO PRINCIPAL ═════════ -->
<div class="container">

  <!-- ═════ FEED ═════ -->
  <div class="feed card">

    <div class="feed-header">
      <h2><i class="ti ti-layout-list"></i> Publicaciones</h2>
    </div>

    <!-- COMPOSER DINÁMICO -->
    <div class="compose">

      <div class="compose-avatar">
        {{ strtoupper(substr(Auth::user()->name,0,2)) }}
      </div>

      <div class="compose-wrap">

        <form action="{{ route('publicaciones.store') }}" method="POST">
          @csrf

          <textarea rows="2"
                    name="contenido"
                    placeholder="¿Qué proyecto estás construyendo hoy?"
                    required></textarea>

          <div class="compose-actions">
            <button class="btn-publish" type="submit">Publicar</button>
          </div>

        </form>

      </div>
    </div>

    <!-- ═════ POSTS DINÁMICOS ═════ -->
    @foreach ($publicaciones as $publicacion)

      <div class="post">

        <div class="post-avatar">
          {{ strtoupper(substr($publicacion->user->name ?? 'U',0,2)) }}
        </div>

        <div class="post-body">

          <div class="post-meta">
            <span class="post-name">
              {{ $publicacion->user->name ?? 'Usuario' }}
            </span>

            <span class="post-handle">
              {{ '@'.$publicacion->user->email ?? '' }}
            </span>

            <span class="post-time">
              {{ $publicacion->created_at->diffForHumans() }}
            </span>
          </div>

          <span class="post-tag">
            <i class="ti ti-flame"></i> Tech
          </span>

          <p class="post-text">
            {{ $publicacion->contenido }}
          </p>

        </div>

      </div>

    @endforeach

  </div>

  <!-- ═════ SIDEBAR ═════ -->
  <aside>
<!-- SUGERENCIAS -->
<div class="card sidebar-section">

  <div class="section-title">
    <i class="ti ti-user-plus"></i> Sugerencias
  </div>

  <ul style="list-style:none;">

    @foreach ($sugerenciasAmigos as $sugerencia)

      @php
        $solicitud = $solicitudes
            ->where('receiver_id', $sugerencia->id)
            ->where('sender_id', Auth::id())
            ->first();
      @endphp

      <li class="friend-suggest">

        <!-- AVATAR -->
        <div class="fav-avatar">
          {{ strtoupper(substr($sugerencia->name,0,2)) }}
        </div>

        <!-- INFO -->
        <div class="friend-info">
          <div class="friend-name">
            {{ $sugerencia->name }}
          </div>

          <div style="font-size:12px; opacity:.7;">

            @if(!$solicitud)
              Persona sugerida

            @elseif($solicitud->status == 'pending')
              <span style="color:#f59e0b;">Solicitud enviada</span>

            @elseif($solicitud->status == 'accepted')
              <span style="color:#22c55e;">Amigos</span>

            @elseif($solicitud->status == 'rejected')
              <span style="color:#ef4444;">Rechazada</span>
            @endif

          </div>
        </div>

        <!-- ACCIONES -->
        <div>

          @if(!$solicitud)

            <form action="{{ route('amigos.enviarSolicitud', $sugerencia->id) }}" method="POST">
              @csrf
              <button class="btn-add">Añadir</button>
            </form>

          @elseif($solicitud->status == 'pending')

            <button class="btn-add" disabled style="opacity:.6;">
              Enviada
            </button>

          @elseif($solicitud->status == 'accepted')

            <span style="color:#22c55e; font-weight:600;">✔ Amigos</span>

          @elseif($solicitud->status == 'rejected')

            <form action="{{ route('amigos.enviarSolicitud', $sugerencia->id) }}" method="POST">
              @csrf
              <button class="btn-add">Reintentar</button>
            </form>

          @endif

        </div>

      </li>

    @endforeach

  </ul>
</div>

   <!-- SOLICITUDES -->
<div class="card sidebar-section">

  <div class="section-title">
    <i class="ti ti-bell"></i> Solicitudes
  </div>

  <ul style="list-style:none;">

    @forelse ($solicitudes as $solicitud)

      <li class="friend-suggest">

        <!-- INFO USUARIO -->
        <div class="friend-info">
          <div class="friend-name">
            {{ $solicitud->sender->name }}
          </div>

          <div style="font-size:12px; opacity:.7;">
            @if($solicitud->status == 'pending')
              Solicitud pendiente
            @elseif($solicitud->status == 'accepted')
              Aceptada
            @elseif($solicitud->status == 'rejected')
              Rechazada
            @endif
          </div>
        </div>

        <!-- ACCIONES -->
        <div style="display:flex; gap:5px;">

          @if($solicitud->status == 'pending')

            <form action="{{ route('amigos.aceptarSolicitud', $solicitud->id) }}" method="POST">
              @csrf
              <button class="btn-add" title="Aceptar">✓</button>
            </form>

            <form action="{{ route('amigos.rechazarSolicitud', $solicitud->id) }}" method="POST">
              @csrf
              <button class="btn-add" title="Rechazar">✕</button>
            </form>

          @elseif($solicitud->status == 'accepted')

            <span style="color:#22c55e; font-weight:600;">
              Amigos
            </span>

          @elseif($solicitud->status == 'rejected')

            <span style="color:#ef4444; font-weight:600;">
              Rechazada
            </span>

          @endif

        </div>

      </li>

    @empty

      <li style="opacity:.6; text-align:center;">
        No tienes solicitudes
      </li>

    @endforelse

  </ul>

</div>
    <!-- AMIGOS -->
    <div class="card sidebar-section">

      <div class="section-title">
        <i class="ti ti-users"></i> Amigos
      </div>

      <ul style="list-style:none;">

        @foreach ($amigos as $amigo)

          <li class="friend-suggest">

            <div class="friend-name">{{ $amigo->name }}</div>

            <div style="display:flex; gap:5px;">

              <a href="{{ route('chat.show', $amigo->id) }}" class="btn-add">
                Chat
              </a>

              <form action="{{ route('amigos.eliminar', $amigo->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button class="btn-add">Eliminar</button>
              </form>

            </div>

          </li>

        @endforeach

      </ul>

    </div>

  </aside>

</div>

<!-- ═════════ FOOTER (IGUAL DISEÑO) ═════════ -->
<footer>
  <div class="footer-inner">
    <span class="footer-brand">TechView Peru</span>
    <span class="footer-copy">© 2024 Todos los derechos reservados</span>
  </div>
</footer>

</body>
</html>