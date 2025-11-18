<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultorio</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Íconos opcionales -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <!-- Estilos personalizados -->
    <style>
        body {
            background-color: #f8f9fa;
        }

        nav.navbar {
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        footer {
            background: #f1f1f1;
            padding: 10px 0;
            text-align: center;
            margin-top: 40px;
            font-size: 14px;
        }

        .container {
            max-width: 1100px;
        }
    </style>
    @livewireStyles
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ url('/') }}">
                🏥 Consultorio
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">

                <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                    @auth
                        @if (Auth::user()->rol == 'doctor')
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('doctor.citas') }}">Mis Citas</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('/usuarios') }}">Pacientes</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Recetas</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('/historial') }}">Historial</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('consulta') }}">Consulta</a>
                            </li>
                        @elseif(Auth::user()->rol == 'paciente')
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('citas.index') }}">Agendar Cita</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('/historial') }}">Mi Historial</a>
                            </li>
                        @endif

                    @endauth
                </ul>

                <ul class="navbar-nav ms-auto">
                    @auth
                        <li class="nav-item">
                            <span class="navbar-text text-white me-3">
                                Hola, {{ Auth::user()->nombre }} ({{ Auth::user()->rol }})
                            </span>
                        </li>

                        <div class="vr bg-white opacity-25 me-3 d-none d-lg-block"></div>

                        <li class="nav-item">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <a class="nav-link" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                            this.closest('form').submit();">

                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        fill="currentColor" class="bi bi-box-arrow-right" viewBox="0 0 16 16"
                                        style="margin-top: -2px;">
                                        <path fill-rule="evenodd"
                                            d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2.1a.5.5 0 0 0 1 0v-2.1A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2.1a.5.5 0 0 0-1 0v2.1z" />
                                        <path fill-rule="evenodd"
                                            d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z" />
                                    </svg>
                                    Cerrar Sesión
                                </a>
                            </form>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Contenido principal -->
    <main class="py-4 min-vh-100">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer>
        <div class="container">
            Proyecto Consultorio — Aplicaciones Web Interactivas © {{ date('Y') }}
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @livewireScripts
</body>

</html>
