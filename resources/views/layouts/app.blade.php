<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'A.C. Enterprises')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @stack('css') <!-- Para estilos extra de DataTables si se necesitan -->

    <style>
        :root {
            --sidebar-width: 250px;
            --sidebar-collapsed-width: 70px;
            --sidebar-bg: #353b41;
            --sidebar-hover: #2b3035;
            --sidebar-active: #17a2b8; /* Teal de la imagen */
            --text-color: #c2c7d0;
        }

        body {
            background-color: #f4f6f9;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            overflow-x: hidden;
        }

        /* Envoltorio principal */
        .wrapper {
            display: flex;
            height: 100vh;
        }

        /* SIDEBAR (Menú Lateral) */
        .sidebar {
            width: var(--sidebar-width);
            background-color: var(--sidebar-bg);
            transition: width 0.3s ease;
            display: flex;
            flex-direction: column;
            z-index: 1000;
            overflow-y: auto;
            overflow-x: hidden;
        }

        /* SIDEBAR ESTADO COLAPSADO */
        body.sidebar-collapsed .sidebar {
            width: var(--sidebar-collapsed-width);
        }

        /* EXPANSIÓN AL HACER HOVER CUANDO ESTÁ COLAPSADO */
        body.sidebar-collapsed .sidebar:hover {
            width: var(--sidebar-width);
        }

        /* Ocultar textos e inputs suavemente al colapsar (y cuando NO hay hover) */
        .hide-on-collapse {
            transition: opacity 0.2s ease;
            white-space: nowrap;
        }

        body.sidebar-collapsed .sidebar:not(:hover) .hide-on-collapse {
            opacity: 0;
            visibility: hidden;
            width: 0;
            height: 0;
            overflow: hidden;
        }

        /* Estilos de la cabecera del logo */
        .sidebar-header {
            background-color: #2e3338;
            padding: 15px 20px;
            display: flex;
            align-items: center;
            border-bottom: 1px solid #2b3035;
            height: 60px; /* Misma altura que el topbar */
        }
        .logo-icon {
            background-color: #e9ecef;
            color: #212529;
            width: 30px;
            height: 30px;
            border-radius: 5px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 900;
            font-size: 1.2rem;
            flex-shrink: 0;
        }

        /* Links del Menú */
        .sidebar-nav {
            padding: 0;
            list-style: none;
        }
        .sidebar-nav .nav-link {
            color: var(--text-color);
            padding: 12px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 0.95rem;
            cursor: pointer;
        }
        .sidebar-nav .nav-link:hover {
            background-color: var(--sidebar-hover);
            color: white;
        }
        .sidebar-nav .nav-link.active {
            background-color: var(--sidebar-active);
            color: white;
        }

        /* Contenedor del ícono para que quede centrado al colapsar */
        .nav-icon {
            width: 30px;
            text-align: center;
            font-size: 1.1rem;
            flex-shrink: 0;
        }

        .right-icon {
            font-size: 0.7rem;
        }

        /* CONTENIDO PRINCIPAL */
        .main-content {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            width: calc(100% - var(--sidebar-width));
            transition: width 0.3s ease;
        }
        body.sidebar-collapsed .main-content {
            width: calc(100% - var(--sidebar-collapsed-width));
        }

        /* Topbar */
        .topbar {
            background-color: #ffffff;
            border-bottom: 1px solid #dee2e6;
            padding: 0 20px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .content-area {
            padding: 20px;
            overflow-y: auto;
            flex-grow: 1;
        }

        /* Personalizar scrollbar del sidebar */
        .sidebar::-webkit-scrollbar { width: 5px; }
        .sidebar::-webkit-scrollbar-track { background: #353b41; }
        .sidebar::-webkit-scrollbar-thumb { background: #555; border-radius: 4px; }
    </style>
</head>
<body class="sidebar-collapsed"> <!-- La clase sidebar-collapsed inicia el menú cerrado. Quítala si quieres que empiece abierto -->

    <div class="wrapper">

        <!-- =======================
            INICIO DEL SIDEBAR
        ======================== -->
        <aside class="sidebar shadow">

            <!-- Logo Header con enlace a home -->
            <a href="{{ route('home') }}" class="sidebar-header text-decoration-none" style="display: flex; align-items: center;">
                <div class="logo-icon">A</div>
                <div class="hide-on-collapse ms-2 text-white" style="font-size: 1.1rem;">
                    <strong>A.C.</strong> <span class="fw-light">Enterprises</span>
                </div>
            </a>

            <!-- Menú Navegación -->
            <ul class="sidebar-nav">

                <!-- Inventario -->
                <li>
                    <a href="#inventarioSubmenu" data-bs-toggle="collapse" class="nav-link active">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-boxes nav-icon"></i>
                            <span class="hide-on-collapse ms-2">Inventario</span>
                        </div>
                        <i class="fas fa-chevron-down right-icon hide-on-collapse"></i>
                    </a>
                    <div class="collapse show" id="inventarioSubmenu">
                        <ul class="sidebar-nav" style="background-color: #2b3035;">
                            <li>
                                <a href="{{ route('inventario.index') }}" class="nav-link ps-4">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-box nav-icon" style="font-size: 0.85rem;"></i>
                                        <span class="hide-on-collapse ms-2">Artículos</span>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <!-- Contabilidad -->
                <li>
                    <a href="#contabilidadSubmenu" data-bs-toggle="collapse" class="nav-link">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-calculator nav-icon"></i>
                            <span class="hide-on-collapse ms-2">Contabilidad</span>
                        </div>
                        <i class="fas fa-chevron-down right-icon hide-on-collapse"></i>
                    </a>
                    <div class="collapse" id="contabilidadSubmenu">
                        <ul class="sidebar-nav" style="background-color: #2b3035;">
                            <li>
                                <a href="{{ route('boleta.index') }}" class="nav-link ps-4">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-receipt nav-icon" style="font-size: 0.85rem;"></i>
                                        <span class="hide-on-collapse ms-2">Boletas</span>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('venta.index') }}" class="nav-link ps-4">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-shopping-cart nav-icon" style="font-size: 0.85rem;"></i>
                                        <span class="hide-on-collapse ms-2">Ventas</span>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <!-- Maestros -->
                <li>
                    <a href="#maestrosSubmenu" data-bs-toggle="collapse" class="nav-link">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-cogs nav-icon"></i>
                            <span class="hide-on-collapse ms-2">Maestros</span>
                        </div>
                        <i class="fas fa-chevron-down right-icon hide-on-collapse"></i>
                    </a>
                    <div class="collapse" id="maestrosSubmenu">
                        <ul class="sidebar-nav" style="background-color: #2b3035;">
                            <li>
                                <a href="{{ route('rol.index') }}" class="nav-link ps-4">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-user-tag nav-icon" style="font-size: 0.85rem;"></i>
                                        <span class="hide-on-collapse ms-2">Roles</span>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('permiso.index') }}" class="nav-link ps-4">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-key nav-icon" style="font-size: 0.85rem;"></i>
                                        <span class="hide-on-collapse ms-2">Permisos</span>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('usuario.index') }}" class="nav-link ps-4">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-users nav-icon" style="font-size: 0.85rem;"></i>
                                        <span class="hide-on-collapse ms-2">Usuarios</span>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('personal.index') }}" class="nav-link ps-4">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-users nav-icon" style="font-size: 0.85rem;"></i>
                                        <span class="hide-on-collapse ms-2">Personal</span>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

            </ul>
        </aside>

        <!-- =======================
            CONTENIDO PRINCIPAL
        ======================== -->
        <div class="main-content">

            <!-- Navbar Superior (Topbar) -->
            <header class="topbar">
                <div>
                    <i class="fas fa-bars text-secondary fs-5" id="menu-toggle" style="cursor: pointer;"></i>
                </div>

                <div class="d-flex align-items-center gap-3">
                    <span class="text-secondary" style="font-weight: 600; font-size: 0.9rem;">
                        <i class="fas fa-user-circle me-1"></i> {{ Auth::user()->Username ?? 'Invitado' }}
                    </span>

                    @auth
                        <button class="btn btn-sm btn-outline-danger d-flex align-items-center gap-1"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fas fa-sign-out-alt"></i>
                            <span class="d-none d-sm-inline">Salir</span>
                        </button>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    @endauth
                </div>
            </header>

            <!-- Área Dinámica de las Vistas -->
            <main class="content-area">
                @yield('content')
            </main>

        </div>
    </div>

    <!-- =======================
        BOTÓN FLOTANTE Y VENTANA DE CHAT IA (desde el segundo código)
    ======================== -->
    <button id="btn-chat-ia" onclick="toggleChat()" style="position: fixed; bottom: 25px; right: 25px; width: 55px; height: 55px; border-radius: 50%; background-color: var(--sidebar-active); color: white; border: none; box-shadow: 0 4px 12px rgba(0,0,0,0.25); z-index: 2000; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: transform 0.2s ease;">
        <i class="fas fa-robot" style="font-size: 1.4rem;"></i>
    </button>

    <div id="ventana-chat-ia" style="display: none; position: fixed; bottom: 95px; right: 25px; width: 360px; height: 500px; background-color: white; border-radius: 12px; box-shadow: 0 8px 24px rgba(0,0,0,0.2); z-index: 2000; flex-direction: column; overflow: hidden; border: 1px solid #e2e8f0; font-family: inherit;">

        <div style="background-color: var(--sidebar-bg); color: white; padding: 15px; font-weight: 600; display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid var(--sidebar-active);">
            <div class="d-flex align-items-center">
                <i class="fas fa-brain me-2 text-info"></i>
                <span>Asistente A.C. Enterprises</span>
            </div>
            <button onclick="toggleChat()" style="background: none; border: none; color: #a0aec0; cursor: pointer; font-size: 1.1rem;"><i class="fas fa-times"></i></button>
        </div>

        <div id="cuerpo-chat-ia" style="flex: 1; padding: 15px; overflow-y: auto; background-color: #f8fafc; font-size: 0.9rem;">
            <div style="margin-bottom: 12px; text-align: left;">
                <span style="background-color: #e2e8f0; padding: 8px 14px; border-radius: 14px; display: inline-block; max-width: 85%; color: #1e293b;">
                    ¡Hola! Soy tu asistente inteligente con Gemini. ¿Qué deseas consultar hoy sobre el inventario, personal o reglamentos?
                </span>
            </div>
        </div>

        <div style="padding: 12px; display: flex; background-color: white; border-top: 1px solid #e2e8f0;">
            <input type="text" id="input-pregunta-ia" placeholder="Escribe tu pregunta aquí..." style="flex: 1; border: 1px solid #cbd5e1; padding: 8px 12px; border-radius: 6px; outline: none; font-size: 0.9rem;" onkeypress="if(event.key === 'Enter') enviarPreguntaFlotante()">
            <button onclick="enviarPreguntaFlotante()" style="background-color: var(--sidebar-active); color: white; border: none; padding: 8px 14px; margin-left: 8px; border-radius: 6px; cursor: pointer; font-size: 0.9rem; font-weight: 500;">
                <i class="fas fa-paper-plane"></i>
            </button>
        </div>
    </div>

    <!-- Scripts base -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts') <!-- Para inyectar JS de Datatables o personalizado -->

    <script>
        // Lógica del botón de 3 rayas para fijar o colapsar permanentemente el menú
        document.getElementById('menu-toggle').addEventListener('click', function() {
            document.body.classList.toggle('sidebar-collapsed');
        });

        // ===========================
        // LÓGICA DEL CHAT IA (combinada)
        // ===========================

        // Abrir/cerrar ventana emergente
        function toggleChat() {
            const chat = document.getElementById('ventana-chat-ia');
            const btn = document.getElementById('btn-chat-ia');
            if (chat.style.display === 'none' || chat.style.display === '') {
                chat.style.display = 'flex';
                btn.style.transform = 'scale(0.9)';
            } else {
                chat.style.display = 'none';
                btn.style.transform = 'scale(1)';
            }
        }

        // Enviar pregunta al endpoint de la IA
        async function enviarPreguntaFlotante() {
            const input = document.getElementById('input-pregunta-ia');
            const cuerpoChat = document.getElementById('cuerpo-chat-ia');
            const preguntaTexto = input.value.trim();

            if (!preguntaTexto) return;

            // Mostrar mensaje del usuario
            cuerpoChat.innerHTML += `
                <div style="margin-bottom: 12px; text-align: right;">
                    <span style="background-color: var(--sidebar-active); color: white; padding: 8px 14px; border-radius: 14px; display: inline-block; max-width: 85%;">
                        ${preguntaTexto}
                    </span>
                </div>
            `;

            input.value = '';
            cuerpoChat.scrollTop = cuerpoChat.scrollHeight;

            // Mostrar estado "cargando"
            const idPensando = 'loading-' + Date.now();
            cuerpoChat.innerHTML += `
                <div id="${idPensando}" style="margin-bottom: 12px; text-align: left;">
                    <span style="background-color: #e2e8f0; padding: 8px 14px; border-radius: 14px; display: inline-block; max-width: 85%; color: #64748b; font-style: italic;">
                        <i class="fas fa-spinner fa-spin me-1"></i> Pensando...
                    </span>
                </div>
            `;
            cuerpoChat.scrollTop = cuerpoChat.scrollHeight;

            try {
                const response = await fetch('{{ url("/api/agente/preguntar") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ pregunta: preguntaTexto })
                });

                const data = await response.json();
                document.getElementById(idPensando).remove();

                if (data.status === 'success') {
                    cuerpoChat.innerHTML += `
                        <div style="margin-bottom: 12px; text-align: left;">
                            <span style="background-color: #e2e8f0; padding: 8px 14px; border-radius: 14px; display: inline-block; max-width: 85%; color: #1e293b; white-space: pre-wrap;">
                                ${data.respuesta}
                            </span>
                        </div>
                    `;
                } else {
                    cuerpoChat.innerHTML += `
                        <div style="margin-bottom: 12px; text-align: left;">
                            <span style="background-color: #fef2f2; color: #991b1b; padding: 8px 14px; border-radius: 14px; display: inline-block; max-width: 85%; border: 1px solid #fee2e2;">
                                Error al procesar la respuesta interna.
                            </span>
                        </div>
                    `;
                }
            } catch (error) {
                document.getElementById(idPensando).remove();
                cuerpoChat.innerHTML += `
                    <div style="margin-bottom: 12px; text-align: left;">
                        <span style="background-color: #fef2f2; color: #991b1b; padding: 8px 14px; border-radius: 14px; display: inline-block; max-width: 85%; border: 1px solid #fee2e2;">
                            Error de red: No se pudo conectar con el servidor.
                        </span>
                    </div>
                `;
            }
            cuerpoChat.scrollTop = cuerpoChat.scrollHeight;
        }
    </script>

</body>
</html>
