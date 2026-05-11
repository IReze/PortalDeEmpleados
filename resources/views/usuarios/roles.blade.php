@extends('layouts.app')

@section('title', 'Panel de Administración')

@section('content')
<div class="container-fluid p-2 p-md-4">
    {{-- Encabezado Institucional Responsivo --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 p-3 bg-white shadow-sm gap-2" 
         style="border-radius: 12px; border-left: 5px solid var(--guinda-chiapas);">
        <div>
            <h4 class="fw-bold mb-0" style="color: var(--guinda-chiapas);">Panel de Administración</h4>
            <p class="text-muted small mb-0">Gestión de accesos y auditoría del sistema</p>
        </div>
    </div>

    {{-- Navegación por Pestañas (Scroll horizontal en móvil) --}}
    <div class="mb-4 bg-white p-2 shadow-sm sticky-top" style="border-radius: 12px; z-index: 10; top: 10px;">
        <ul class="nav nav-pills flex-nowrap overflow-auto pb-1" id="adminTabs" role="tablist" style="scrollbar-width: none;">
            <li class="nav-item" role="presentation">
                <button class="nav-link active fw-bold text-nowrap" id="roles-tab" data-bs-toggle="pill" data-bs-target="#roles-content" type="button" role="tab">
                    <i class="bi bi-people-fill me-2"></i>Gestión de Roles
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link fw-bold text-nowrap" id="logs-tab" data-bs-toggle="pill" data-bs-target="#logs-content" type="button" role="tab">
                    <i class="bi bi-journal-text me-2"></i>Historial de Auditoría
                </button>
            </li>
        </ul>
    </div>

    <div class="tab-content" id="adminTabsContent">
        
        {{-- PESTAÑA 1: GESTIÓN DE ROLES --}}
        <div class="tab-pane fade show active" id="roles-content" role="tabpanel">
            
            {{-- Buscador Responsivo --}}
            <div class="card border-0 shadow-sm mb-4" style="border-radius: 15px;">
                <div class="card-body p-3">
                    <form action="{{ route('usuarios.roles') }}" method="GET" class="row g-2">
                        <div class="col-12 col-md-10">
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0"><i class="bi bi-search"></i></span>
                                <input type="text" name="buscar" class="form-control bg-light border-0 shadow-none" 
                                       placeholder="Buscar por nombre o CURP..." value="{{ request('buscar') }}">
                            </div>
                        </div>
                        <div class="col-12 col-md-2">
                            <button type="submit" class="btn text-white w-100 fw-bold py-2 py-md-0" style="background-color: var(--verde-chiapas); border-radius: 8px;">
                                Filtrar
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Tabla de Roles con Scroll --}}
            <div class="card border-0 shadow-sm" style="border-radius: 15px; overflow: hidden;">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0" style="min-width: 800px;">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4 py-3 text-muted small fw-bold">EMPLEADO / CURP</th>
                                <th class="py-3 text-muted small fw-bold">ROL ACTUAL</th>
                                <th class="py-3 text-muted small fw-bold">CAMBIAR NIVEL</th>
                                <th class="py-3 text-muted small fw-bold text-end pe-4">ACCIÓN</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($usuarios as $u)
                            <tr>
                                <td class="ps-4">
                                    <div class="fw-bold text-dark">{{ $u->name }}</div>
                                    <div class="small text-muted">{{ $u->curp }}</div>
                                </td>
                                <td>
                                    <span class="badge rounded-pill px-3 py-2 
                                        {{ $u->hasRole('admin') ? 'bg-danger' : ($u->hasRole('usuario_normal') ? 'bg-secondary' : 'bg-primary') }}">
                                        {{ strtoupper($u->getRoleNames()->first() ?? 'SIN ROL') }}
                                    </span>
                                </td>
                                <td>
                                    <form action="{{ route('usuarios.updateRole', $u->id) }}" method="POST" id="form-role-{{ $u->id }}">
                                        @csrf @method('PUT')
                                        <select name="role" class="form-select form-select-sm border-2 bg-light shadow-none" style="max-width: 180px; border-radius: 8px;">
                                            @foreach($roles as $role)
                                                <option value="{{ $role->name }}" {{ $u->hasRole($role->name) ? 'selected' : '' }}>
                                                    {{ strtoupper($role->name) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </form>
                                </td>
                                <td class="text-end pe-4">
                                    <button type="submit" form="form-role-{{ $u->id }}" class="btn btn-sm text-white fw-bold shadow-sm px-3" style="background-color: var(--guinda-chiapas); border-radius: 8px;">
                                        <i class="bi bi-arrow-repeat me-1"></i> Actualizar
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer bg-white border-0 py-3 overflow-auto">
                    {{ $usuarios->appends(['buscar' => request('buscar')])->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>

        {{-- PESTAÑA 2: HISTORIAL DE AUDITORÍA --}}
        <div class="tab-pane fade" id="logs-content" role="tabpanel">
            <div class="card border-0 shadow-sm" style="border-radius: 15px; overflow: hidden;">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0" style="min-width: 900px;">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4 py-3 text-muted small fw-bold">FECHA Y HORA</th>
                                <th class="py-3 text-muted small fw-bold">USUARIO</th>
                                <th class="py-3 text-muted small fw-bold">ACCIÓN</th>
                                <th class="py-3 text-muted small fw-bold">MÓDULO</th>
                                <th class="py-3 text-muted small fw-bold pe-4">DETALLES</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($logs as $log)
                            <tr>
                                <td class="ps-4 small text-nowrap">
                                    <i class="bi bi-clock me-1"></i> {{ $log->created_at->format('d/m/Y H:i') }}
                                </td>
                                <td>
                                    <div class="fw-bold small text-dark">{{ $log->user->name ?? 'Sistema' }}</div>
                                </td>
                                <td>
                                    @php
                                        $bgAccion = 'bg-success';
                                        if($log->accion == 'ELIMINAR') $bgAccion = 'bg-danger';
                                        if($log->accion == 'EDITAR') $bgAccion = 'bg-warning text-dark';
                                    @endphp
                                    <span class="badge {{ $bgAccion }}" style="font-size: 0.65rem; font-weight: 800;">
                                        {{ $log->accion }}
                                    </span>
                                </td>
                                <td class="small fw-bold text-muted">{{ $log->modulo }}</td>
                                <td class="small text-secondary pe-4" style="max-width: 300px; white-space: normal;">
                                    {{ $log->detalles }}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted small fw-bold">
                                    No se han registrado movimientos de auditoría.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="card-footer bg-white border-0 py-3">
                    {{ $logs->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Estilos para las pestañas institucionales */
    .nav-pills .nav-link {
        color: var(--oscuro-chiapas);
        padding: 10px 20px;
        border-radius: 8px;
        transition: 0.3s;
    }
    .nav-pills .nav-link.active {
        background-color: var(--guinda-chiapas) !important;
        color: white !important;
        box-shadow: 0 4px 10px rgba(201, 1, 102, 0.2);
    }
    .nav-pills .nav-link:hover:not(.active) {
        background-color: rgba(201, 1, 102, 0.05);
        color: var(--guinda-chiapas);
    }

    /* Scroll de tablas suave */
    .table-responsive { -webkit-overflow-scrolling: touch; }

    /* Estilo para los select en la tabla */
    .form-select:focus {
        border-color: var(--guinda-chiapas) !important;
        box-shadow: 0 0 0 0.25rem rgba(201, 1, 102, 0.1) !important;
    }
</style>
@endsection