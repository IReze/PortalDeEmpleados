@extends('layouts.app')

@section('content')
<div class="container-fluid p-4">
    {{-- Encabezado Institucional --}}
    <div class="d-flex justify-content-between align-items-center mb-4 p-3 bg-white shadow-sm" style="border-radius: 12px; border-left: 5px solid var(--guinda-chiapas);">
        <div>
            <h4 class="fw-bold mb-0" style="color: var(--guinda-chiapas);">Panel de Administración</h4>
            <p class="text-muted small mb-0">Control de niveles de acceso y auditoría de movimientos</p>
        </div>
    </div>

    {{-- Navegación por Pestañas --}}
    <ul class="nav nav-pills mb-4 bg-white p-2 shadow-sm" style="border-radius: 12px;" id="adminTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active fw-bold" id="roles-tab" data-bs-toggle="pill" data-bs-target="#roles-content" type="button" role="tab">
                <i class="bi bi-people-fill me-2"></i>Gestión de Roles
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link fw-bold" id="logs-tab" data-bs-toggle="pill" data-bs-target="#logs-content" type="button" role="tab">
                <i class="bi bi-journal-text me-2"></i>Historial de Auditoría
            </button>
        </li>
    </ul>

    {{-- Contenido de las Pestañas --}}
    <div class="tab-content" id="adminTabsContent">
        
        {{-- PESTAÑA 1: GESTIÓN DE ROLES --}}
        <div class="tab-pane fade show active" id="roles-content" role="tabpanel" aria-labelledby="roles-tab">
            
            {{-- Buscador de Usuarios --}}
            <div class="card border-0 shadow-sm mb-4" style="border-radius: 15px;">
                <div class="card-body p-3">
                    <form action="{{ route('usuarios.roles') }}" method="GET" class="row g-2">
                        <div class="col-md-10">
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0"><i class="bi bi-search"></i></span>
                                <input type="text" name="buscar" class="form-control bg-light border-0 shadow-none" 
                                       placeholder="Buscar por nombre o CURP..." value="{{ request('buscar') }}">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn text-white w-100 fw-bold" style="background-color: var(--verde-chiapas); border-radius: 8px;">
                                Filtrar
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Tabla de Usuarios --}}
            <div class="card border-0 shadow-sm" style="border-radius: 15px; overflow: hidden;">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
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
                                        <select name="role" class="form-select form-select-sm border-0 bg-light shadow-none" style="max-width: 200px;">
                                            @foreach($roles as $role)
                                                <option value="{{ $role->name }}" {{ $u->hasRole($role->name) ? 'selected' : '' }}>
                                                    {{ strtoupper($role->name) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </form>
                                </td>
                                <td class="text-end pe-4">
                                    <button type="submit" form="form-role-{{ $u->id }}" class="btn btn-sm text-white fw-bold shadow-sm" style="background-color: var(--guinda-chiapas); border-radius: 8px;">
                                        <i class="bi bi-save me-1"></i> Actualizar
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer bg-white border-0 py-3">
                    {{ $usuarios->appends(['buscar' => request('buscar')])->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>

        {{-- PESTAÑA 2: HISTORIAL DE AUDITORÍA --}}
        <div class="tab-pane fade" id="logs-content" role="tabpanel" aria-labelledby="logs-tab">
            <div class="card border-0 shadow-sm" style="border-radius: 15px; overflow: hidden;">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4 py-3 text-muted small fw-bold">FECHA Y HORA</th>
                                <th class="py-3 text-muted small fw-bold">USUARIO</th>
                                <th class="py-3 text-muted small fw-bold">ACCIÓN</th>
                                <th class="py-3 text-muted small fw-bold">MÓDULO</th>
                                <th class="py-3 text-muted small fw-bold">DETALLES</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($logs as $log)
                            <tr>
                                <td class="ps-4 small">{{ $log->created_at->format('d/m/Y H:i:s') }}</td>
                                <td>
                                    <div class="fw-bold small text-dark">{{ $log->user->name ?? 'Sistema' }}</div>
                                </td>
                                <td>
                                    <span class="badge {{ $log->accion == 'ELIMINAR' ? 'bg-danger' : ($log->accion == 'EDITAR' ? 'bg-warning text-dark' : 'bg-success') }}" style="font-size: 0.7rem;">
                                        {{ $log->accion }}
                                    </span>
                                </td>
                                <td class="small fw-bold text-muted">{{ $log->modulo }}</td>
                                <td class="small text-secondary">{{ $log->detalles }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted">
                                    <i class="bi bi-info-circle me-2"></i>No se han registrado movimientos de auditoría aún.
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
    .nav-pills .nav-link.active {
        background-color: var(--guinda-chiapas) !important;
        color: white !important;
    }
    .nav-pills .nav-link {
        color: var(--bs-gray-600);
        transition: 0.3s;
    }
    .nav-pills .nav-link:hover:not(.active) {
        background-color: #f8f9fa;
        color: var(--guinda-chiapas);
    }
</style>
@endsection