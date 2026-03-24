<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal de Empleados - Chiapas</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" type="text/css" href="https://npmcdn.com/flatpickr/dist/themes/material_green.css">

    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://npmcdn.com/flatpickr/dist/l10n/es.js"></script>

</head><meta name="viewport" content="width=device-width, initial-scale=1.0">
<body class="d-flex flex-column min-vh-100">

    <div class="header-top-black px-4">
        <img src="{{ asset('images/escudo-icono.png') }}" alt="Logo" style="height: 25px;">
        <div class="ms-auto text-white fw-bold small" style="letter-spacing: 1px;">CHIAPAS.GOB.MX</div>
    </div>

    <div class="header-title-white py-2 px-4">
        <h4 class="fw-bold mb-0" style="color: var(--verde-chiapas);">Portal de Empleados</h4>
    </div>

    <div class="d-flex flex-grow-1" id="wrapper">
        @auth
        <div id="sidebar-wrapper" class="sidebar-main border-end shadow-sm">
            <div class="sidebar-header text-center py-4">
                <div class="mb-1 fw-bolder fs-4">CHIAPAS</div>
                <!-- <div class="small opacity-75">Portal de Empleados</div> -->
            </div>
            <div class="list-group list-group-flush pt-2">
                <a href="{{ route('dashboard') }}" class="list-group-item list-group-item-action py-3 border-0 fw-bold text-secondary">
                    <i class="bi bi-house-door me-3"></i> Inicio
                </a>
                <a href="{{ route('agenda.index') }}" class="list-group-item list-group-item-action py-3 border-0 fw-bold text-secondary">
                    <i class="bi bi-calendar3 me-3"></i> Agenda
                </a>
                <a href="{{ route('asistencias.index') }}" class="list-group-item list-group-item-action py-3 border-0 fw-bold text-secondary">
                    <i class="bi bi-clock-history me-3"></i> Control de Asistencias
                </a>
                <a href="{{ route('avisos.index') }}" class="list-group-item list-group-item-action py-3 border-0 fw-bold text-secondary">
                    <i class="bi bi-bell me-3"></i> Avisos o Circulares
                </a>
                @if(Auth::user()->hasRole('admin'))
                <a href="{{ route('usuarios.roles') }}" class="list-group-item list-group-item-action py-3 border-0 fw-bold text-secondary">
                    <i class="bi bi-person-gear me-3"></i> Panel de Administración
                </a>
                @endif
            </div>
        </div>
        @endauth

        <div id="page-content-wrapper" class="d-flex flex-column w-100">
            @auth
            <nav class="navbar navbar-expand-lg navbar-light bg-white py-3 px-4 navbar-user-custom">
                <div class="container-fluid">
                    <div class="ms-auto d-flex align-items-center fw-bold">
                        <div class="dropdown">
                            <a class="nav-link dropdown-toggle d-flex align-items-center p-0" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <span class="me-3 text-dark">{{ Auth::user()->name }}</span>
                                <div class="avatar-circle">
                                    {{ Auth::user()->initial }}
                                </div>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-3">
                                <li>
                                    <a class="dropdown-item py-2" href="{{ route('profile.edit') }}">
                                        <i class="bi bi-person-gear me-2"></i> Editar Perfil
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger py-2 w-100 text-start border-0 bg-transparent">
                                            <i class="bi bi-box-arrow-right me-2"></i> Cerrar Sesión
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </nav>
            @endauth

            <main class="flex-grow-1">
                @yield('content')
            </main>
        </div>
    </div>

    <footer class="main-footer">
        <div class="container-fluid text-center">
            <p class="mb-0">&copy; {{ date('Y') }} Gobierno del Estado de Chiapas</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>