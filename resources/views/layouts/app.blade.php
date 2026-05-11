<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Portal de Empleados</title>

    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" type="text/css" href="https://npmcdn.com/flatpickr/dist/themes/material_green.css">

    {{-- TU CSS GLOBAL --}}
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <style>
        #wrapper { display: flex; width: 100%; transition: all 0.3s; }
        #sidebar-wrapper { min-width: 280px; max-width: 280px; transition: all 0.3s; z-index: 1000; position: relative; }
        #sidebar-wrapper.toggled { margin-left: -280px; }
        #page-content-wrapper { width: 100%; overflow-x: hidden; display: flex; flex-direction: column; }

        @media (max-width: 992px) {
            #sidebar-wrapper { margin-left: -280px; position: fixed; height: 100%; }
            #sidebar-wrapper.toggled { margin-left: 0; }
        }
        
        .active-link {
            background-color: rgba(0, 152, 135, 0.1) !important;
            color: var(--verde-chiapas) !important;
            border-right: 4px solid var(--verde-chiapas) !important;
        }
    </style>
</head>
<body class="d-flex flex-column min-vh-100">

    {{-- 1. BANNERS INSTITUCIONALES --}}
    <div class="header-top-black px-4">
        <img src="{{ asset('images/escudo-icono.png') }}" alt="Logo" style="height: 25px;">
        <div class="ms-auto text-white fw-bold small d-none d-sm-block" style="letter-spacing: 1px;">CHIAPAS.GOB.MX</div>
    </div>

    <div class="header-title-white py-2 px-4 d-flex align-items-center">
        @auth
        <button class="btn border-0 me-2 d-lg-none" id="menu-toggle-mobile">
            <i class="bi bi-list fs-3" style="color: var(--verde-chiapas);"></i>
        </button>
        @endauth
        <h4 class="fw-bold mb-0" style="color: var(--verde-chiapas);">Portal de Empleados</h4>
    </div>

    <div id="wrapper" class="flex-grow-1">
        @auth
        {{-- 2. SIDEBAR CON TODOS LOS ENLACES ORIGINALES --}}
        <div id="sidebar-wrapper" class="sidebar-main shadow-sm">
            <div class="sidebar-header text-center py-4">
                <div class="mb-1 fw-bolder fs-4 text-white text-uppercase">Chiapas</div>
            </div>
            <div class="list-group list-group-flush pt-2">
                <a href="{{ route('dashboard') }}" class="list-group-item list-group-item-action py-3 border-0 fw-bold {{ request()->routeIs('dashboard') ? 'active-link' : 'text-secondary' }}">
                    <i class="bi bi-house-door me-3"></i> Inicio
                </a>
                <a href="{{ route('agenda.index') }}" class="list-group-item list-group-item-action py-3 border-0 fw-bold {{ request()->routeIs('agenda.*') ? 'active-link' : 'text-secondary' }}">
                    <i class="bi bi-calendar3 me-3"></i> Agenda
                </a>
                <a href="{{ route('asistencias.index') }}" class="list-group-item list-group-item-action py-3 border-0 fw-bold {{ request()->routeIs('asistencias.*') ? 'active-link' : 'text-secondary' }}">
                    <i class="bi bi-clock-history me-3"></i> Control de Asistencias
                </a>
                <a href="{{ route('avisos.index') }}" class="list-group-item list-group-item-action py-3 border-0 fw-bold {{ request()->routeIs('avisos.*') ? 'active-link' : 'text-secondary' }}">
                    <i class="bi bi-bell me-3"></i> Avisos o Circulares
                </a>
                <a href="{{ route('incidencias.create') }}" class="list-group-item list-group-item-action py-3 border-0 fw-bold {{ request()->routeIs('incidencias.*') ? 'active-link' : 'text-secondary' }}">
                    <i class="bi bi-exclamation-triangle me-3"></i> Incidencias Laborales
                </a>

                {{-- 3. CONDICIONAL DE ADMIN RESTAURADO --}}
                @if(Auth::user()->hasRole('admin'))
                
                <a href="{{ route('usuarios.roles') }}" class="list-group-item list-group-item-action py-3 border-0 fw-bold {{ request()->routeIs('usuarios.*') ? 'active-link' : 'text-secondary' }}">
                    <i class="bi bi-person-gear me-3"></i> Panel de Usuarios
                </a>
                @endif
            </div>
        </div>
        @endauth

        {{-- 4. CONTENIDO PRINCIPAL --}}
        <div id="page-content-wrapper">
            @auth
            <nav class="navbar navbar-expand-lg navbar-light bg-white py-3 px-4 navbar-user-custom shadow-sm">
                <div class="container-fluid p-0">
                    {{-- Botón Toggle para PC --}}
                    <button class="btn d-none d-lg-block me-3 border-0" id="menu-toggle-pc">
                        <i class="bi bi-list fs-4 text-muted"></i>
                    </button>
                    
                    <div class="ms-auto d-flex align-items-center fw-bold">
                        <div class="dropdown">
                            <a class="nav-link dropdown-toggle d-flex align-items-center p-0" href="#" role="button" data-bs-toggle="dropdown">
                                <span class="me-3 text-dark d-none d-md-inline">{{ Auth::user()->name }}</span>
                                <div class="avatar-circle">
                                    {{ Auth::user()->initial }}
                                </div>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-3 animate slideIn">
                                <li>
                                    <a class="dropdown-item py-2" href="{{ route('profile.edit') }}">
                                        <i class="bi bi-person-circle me-2"></i> Mi Perfil
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

    {{-- 5. FOOTER INSTITUCIONAL --}}
    <footer class="main-footer mt-auto">
        <div class="container-fluid text-center">
            <p class="mb-0">&copy; {{ date('Y') }} Gobierno del Estado de Chiapas</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://npmcdn.com/flatpickr/dist/l10n/es.js"></script>

    <script>
        const sidebar = document.getElementById('sidebar-wrapper');
        const btnMobile = document.getElementById('menu-toggle-mobile');
        const btnPC = document.getElementById('menu-toggle-pc');

        [btnMobile, btnPC].forEach(btn => {
            if(btn) {
                btn.onclick = (e) => {
                    e.preventDefault();
                    sidebar.classList.toggle('toggled');
                }
            }
        });
    </script>
</body>
</html>