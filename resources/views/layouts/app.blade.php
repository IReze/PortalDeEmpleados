<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal de Empleados - Chiapas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <style>
        body { background-color: #f4f7f6; overflow-x: hidden; }
        #sidebar-wrapper { min-height: 100vh; width: 280px; transition: all 0.3s; }
        .nav-link:hover { background-color: #e6f5f3; color: #009887 !important; }
        .dropdown-toggle::after { display: none; } /* Estilo limpio como en tu imagen */
    </style>
</head>
<body>

    <div class="d-flex align-items-center px-4" style="background-color: #000; height: 50px;">
        <img src="{{ asset('images/escudo-icono.png') }}" alt="Gobierno de Chiapas" style="height: 25px;">
        <div class="ms-auto text-white fw-bold small" style="letter-spacing: 1px;">CHIAPAS.GOB.MX</div>
    </div>

    <div class="py-2 px-4 bg-white border-bottom" style="border-bottom: 2px solid #009887 !important;">
        <h4 class="fw-bold mb-0" style="color: #009887;">Portal de Empleados</h4>
    </div>

    <div class="d-flex" id="wrapper">
        
        @auth
        <div id="sidebar-wrapper" class="bg-white border-end shadow-sm">
            <div class="sidebar-heading text-center py-4" style="background-color: #009887; color: white;">
                <div class="mb-1" style="font-size: 1.5rem; font-weight: 800; letter-spacing: 1px;">Menu</div>
                
            </div>
            
            <div class="list-group list-group-flush pt-2">
                <a href="{{ route('agenda.index') }}" class="list-group-item list-group-item-action py-3 border-0 fw-bold text-secondary">
                    <i class="bi bi-calendar3 me-3"></i> Agenda
                </a>
                <a href="{{ route('asistencias.index') }}" class="list-group-item list-group-item-action py-3 border-0 fw-bold text-secondary">
                    <i class="bi bi-clock-history me-3"></i> Control de Asistencias
                </a>
            </div>
        </div>
        @endauth

        <div id="page-content-wrapper" class="w-100">
            
            @auth
            <nav class="navbar navbar-expand-lg navbar-light bg-white py-3 px-4 border-bottom" style="border-bottom: 3px solid #C90166;">
                <div class="container-fluid">
                    <div class="ms-auto d-flex align-items-center">
                        <div class="dropdown">
                            <a class="nav-link dropdown-toggle d-flex align-items-center fw-bold text-uppercase p-0" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="color: #4d4d4d; font-size: 0.9rem;">
                                <span class="me-3">{{ Auth::user()->name }}</span>
                                <div style="width: 40px; height: 40px; background-color: #009887; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 1.1rem; border: 2px solid white; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                </div>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-3" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item py-2" href="{{ route('profile.edit') }}"><i class="bi bi-person-gear me-2"></i> Editar Perfil</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger py-2"><i class="bi bi-box-arrow-right me-2"></i> Cerrar Sesión</button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </nav>
            @endauth

            <main>
                @yield('content')
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>