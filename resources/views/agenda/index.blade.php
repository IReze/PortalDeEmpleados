@extends('layouts.app')

@section('title', 'Directorio Institucional - Chiapas')

@section('content')
<div class="container-fluid p-4">
    <div class="d-flex justify-content-between align-items-center mb-4 p-3 bg-white shadow-sm" style="border-radius: 12px; border-left: 5px solid var(--guinda-chiapas);">
        <div>
            <h4 class="fw-bold mb-0" style="color: var(--guinda-chiapas);">Directorio Institucional</h4>
            <p class="text-muted small mb-0">Gestión de Servidores Públicos - Orden Alfabético</p>
        </div>
       <button type="button" class="btn text-white px-4 fw-bold shadow-sm" 
                data-bs-toggle="modal" data-bs-target="#nuevoRegistroModal"
                style="background-color: var(--verde-chiapas); border-radius: 8px;">
            <i class="bi bi-person-plus-fill me-2"></i> Nuevo Registro
        </button>
    </div>

    <div class="card border-0 shadow-sm mb-4" style="border-radius: 15px;">
        <div class="card-body p-4">
            <form action="{{ route('agenda.index') }}" method="GET" class="row g-2">
                <div class="col-md-10">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-0"><i class="bi bi-search text-muted"></i></span>
                        <input type="text" name="buscar" class="form-control bg-light border-0" 
                               placeholder="Buscar por nombre, área o extensión..." 
                               value="{{ request('buscar') }}" style="height: 45px;">
                    </div>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn text-white w-100 h-100 fw-bold" style="background-color: var(--guinda-chiapas); border-radius: 8px;">
                        Buscar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="card border-0 shadow-sm" style="border-radius: 15px; overflow: hidden;">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" id="tabla-directorio">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4 py-3 text-muted small fw-bold">NOMBRE</th>
                        <th class="py-3 text-muted small fw-bold">ÁREA</th>
                        <!-- <th class="py-3 text-muted small fw-bold">CARGO</th> -->
                        <th class="py-3 text-muted small fw-bold text-center">EXT.</th>
                        <th class="py-3 text-muted small fw-bold text-center">PISO</th>
                        <th class="py-3 text-muted small fw-bold text-end pe-4">ACCIONES</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($contactos as $persona)
                    <tr>
                        <td class="ps-4">
                            <div class="d-flex align-items-center">
                                <div class="avatar-circle me-3 shadow-sm" style="background-color: var(--guinda-chiapas); color: white; width: 38px; height: 38px; display: flex; align-items: center; justify-content: center; border-radius: 50%; font-weight: bold; font-size: 0.9rem;">
                                    {{ strtoupper(substr($persona->nombre, 0, 1)) }}
                                </div>
                                <span class="fw-bold text-dark" style="font-size: 0.9rem;">{{ $persona->nombre }}</span>
                            </div>
                        </td>
                        <td>
                            <span class="badge px-2 py-1" style="background-color: rgba(40, 92, 77, 0.1); color: var(--verde-chiapas); border: 1px solid rgba(40, 92, 77, 0.2); font-size: 0.75rem; white-space: normal; text-align: left; display: block;">
                                {{ $persona->area }}
                            </span>
                        </td>
                        <!-- <td class="text-muted small">{{ $persona->cargo ?? 'N/A' }}</td> -->
                        <td class="text-center fw-bold" style="color: var(--guinda-chiapas);">{{ $persona->extension ?? '-' }}</td>
                        <td class="text-center text-secondary small">{{ $persona->piso ?? '-' }}</td>
                        <td class="text-end pe-4">
                            <div class="btn-group shadow-sm" style="border-radius: 8px; overflow: hidden;">
                                <button type="button" class="btn btn-sm btn-white border-end" 
                                        onclick="openEditModal({{ json_encode($persona) }})" title="Editar">
                                    <i class="bi bi-pencil-square text-primary"></i>
                                </button>
                                
                                <form action="{{ route('agenda.destroy', $persona->id) }}" method="POST" class="form-eliminar">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-white text-danger" title="Eliminar">
                                        <i class="bi bi-trash3-fill"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">No se encontraron resultados para su búsqueda.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($contactos->hasPages())
        <div class="card-footer bg-white border-0 py-4 d-flex justify-content-center">
            {{ $contactos->appends(['buscar' => request('buscar')])->links('pagination::bootstrap-5') }}
        </div>
        @endif
    </div>
</div>

<div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 15px; border: none;">
            <div class="modal-header text-white" style="background-color: var(--guinda-chiapas); border-radius: 15px 15px 0 0;">
                <h5 class="modal-title fw-bold"><i class="bi bi-pencil-square me-2"></i>Actualizar Información</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-muted">Nombre Completo</label>
                        <input type="text" name="nombre" id="edit_nombre" class="form-control bg-light border-0 shadow-none" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-muted">Área Adscrita</label>
                        <input type="text" name="area" id="edit_area" class="form-control bg-light border-0 shadow-none" required>
                    </div>
                    <!-- <div class="mb-3">
                        <label class="form-label fw-bold small text-muted">Cargo</label>
                        <input type="text" name="cargo" id="edit_cargo" class="form-control bg-light border-0 shadow-none">
                    </div> -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold small text-muted">Extensión</label>
                            <input type="text" name="extension" id="edit_extension" class="form-control bg-light border-0 shadow-none">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold small text-muted">Piso</label>
                            <input type="text" name="piso" id="edit_piso" class="form-control bg-light border-0 shadow-none">
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 p-4 pt-0">
                    <button type="button" class="btn btn-light fw-bold" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn text-white fw-bold px-4" style="background-color: var(--verde-chiapas);">Guardar Cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="nuevoRegistroModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 15px; border: none;">
            <div class="modal-header text-white" style="background-color: var(--verde-chiapas); border-radius: 15px 15px 0 0;">
                <h5 class="modal-title fw-bold"><i class="bi bi-person-plus-fill me-2"></i>Nuevo Registro</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('agenda.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-muted">Nombre Completo</label>
                        <input type="text" name="nombre" class="form-control bg-light border-0 shadow-none" placeholder="Ej. Juan Pérez" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-muted">Área Adscrita</label>
                        <input type="text" name="area" class="form-control bg-light border-0 shadow-none" placeholder="Unidad de Informática" required>
                    </div>
                    <!-- <div class="mb-3">
                        <label class="form-label fw-bold small text-muted">Cargo</label>
                        <input type="text" name="cargo" class="form-control bg-light border-0 shadow-none" placeholder="Jefe de Departamento">
                    </div> -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold small text-muted">Extensión</label>
                            <input type="text" name="extension" class="form-control bg-light border-0 shadow-none" placeholder="20XXX">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold small text-muted">Piso</label>
                            <input type="text" name="piso" class="form-control bg-light border-0 shadow-none" placeholder="1o.">
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 p-4 pt-0">
                    <button type="button" class="btn btn-light fw-bold" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn text-white fw-bold px-4 shadow-sm" style="background-color: var(--guinda-chiapas);">Guardar Registro</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // 1. Manejo del Modal de Edición
    function openEditModal(persona) {
        document.getElementById('editForm').action = "/agenda/" + persona.id;
        document.getElementById('edit_nombre').value = persona.nombre;
        document.getElementById('edit_area').value = persona.area;
        //document.getElementById('edit_cargo').value = persona.cargo || '';
        document.getElementById('edit_extension').value = persona.extension || '';
        document.getElementById('edit_piso').value = persona.piso || '';
        
        var myModal = new bootstrap.Modal(document.getElementById('editModal'));
        myModal.show();
    }

    // 2. Confirmación de Eliminación con SweetAlert2
    $('.form-eliminar').submit(function(e) {
        e.preventDefault();
        Swal.fire({
            title: '¿Desea eliminar este registro?',
            text: "Esta acción no se puede deshacer.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#C90166', // Guinda
            cancelButtonColor: '#009887',  // Verde
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                this.submit();
            }
        });
    });

    // 3. Alerta de éxito si existe sesión
    @if(session('status'))
        Swal.fire({
            icon: 'success',
            title: '¡Operación Exitosa!',
            text: '{{ session('status') }}',
            confirmButtonColor: '#C90166',
            timer: 2500
        });
    @endif
</script>

<style>
    .table-hover tbody tr:hover { background-color: rgba(98, 17, 50, 0.02) !important; }
    .page-link { color: var(--guinda-chiapas); border: none; }
    .page-item.active .page-link { background-color: var(--guinda-chiapas) !important; border-color: var(--guinda-chiapas) !important; }
</style>
@endsection