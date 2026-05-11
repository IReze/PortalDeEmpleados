@extends('layouts.app')

@section('title', 'Directorio Institucional - Chiapas')

@section('content')
<div class="container-fluid p-2 p-md-4">
    {{-- ENCABEZADO --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 p-3 bg-white shadow-sm gap-3" 
         style="border-radius: 12px; border-left: 5px solid var(--guinda-chiapas);">
        <div>
            <h4 class="fw-bold mb-0" style="color: var(--guinda-chiapas);">Directorio Institucional</h4>
            <p class="text-muted small mb-0">Gestión de Servidores Públicos - Orden Alfabético</p>
        </div>
        
        @can('gestionar agenda')
        <button type="button" class="btn text-white px-4 fw-bold shadow-sm py-2" 
                data-bs-toggle="modal" data-bs-target="#nuevoRegistroModal"
                style="background-color: var(--verde-chiapas); border-radius: 8px;">
            <i class="bi bi-person-plus-fill me-2"></i> Nuevo Registro
        </button>
        @endcan
    </div>

    {{-- BUSCADOR DINÁMICO --}}
    <div class="card border-0 shadow-sm mb-4" style="border-radius: 15px;">
        <div class="card-body p-3 p-md-4">
            <div class="row g-2">
                <div class="col-12">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-0"><i class="bi bi-search text-muted"></i></span>
                        <input type="text" id="input-buscar" class="form-control bg-light border-0 shadow-none" 
                               placeholder="Escriba nombre, área o extensión para buscar..." 
                               value="{{ request('buscar') }}" style="height: 45px;" autocomplete="off">
                    </div>
                    {{-- Spinner de carga --}}
                    <div id="loading-spinner" class="text-center mt-2 d-none">
                        <div class="spinner-border spinner-border-sm text-success" role="status"></div>
                        <span class="small text-muted ms-1">Buscando...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- TABLA --}}
    <div class="card border-0 shadow-sm" style="border-radius: 15px; overflow: hidden;">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" id="tabla-directorio" style="min-width: 750px;">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4 py-3 text-muted small fw-bold">NOMBRE</th>
                        <th class="py-3 text-muted small fw-bold">ÁREA</th>
                        <th class="py-3 text-muted small fw-bold text-center">EXT.</th>
                        <th class="py-3 text-muted small fw-bold text-center">PISO</th>
                        @can('gestionar agenda')
                        <th class="py-3 text-muted small fw-bold text-end pe-4">ACCIONES</th>
                        @endcan
                    </tr>
                </thead>
                <tbody id="tabla-body">
                    {{-- Aquí se cargan las filas dinámicamente --}}
                    @include('agenda.partials.tabla_filas')
                </tbody>
            </table>
        </div>

        <div id="paginacion-container" class="card-footer bg-white border-0 py-4 d-flex justify-content-center">
            {{ $contactos->appends(['buscar' => request('buscar')])->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>

@can('gestionar agenda')
{{-- MODAL NUEVO REGISTRO --}}
<div class="modal fade" id="nuevoRegistroModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 15px;">
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
                    <div class="row">
                        <div class="col-6 mb-3">
                            <label class="form-label fw-bold small text-muted">Extensión</label>
                            <input type="text" name="extension" class="form-control bg-light border-0 shadow-none" placeholder="20XXX">
                        </div>
                        <div class="col-6 mb-3">
                            <label class="form-label fw-bold small text-muted">Piso</label>
                            <input type="text" name="piso" class="form-control bg-light border-0 shadow-none" placeholder="1o.">
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 p-4 pt-0">
                    <button type="button" class="btn btn-light fw-bold" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn text-white fw-bold px-4" style="background-color: var(--guinda-chiapas);">Guardar Registro</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- MODAL EDITAR REGISTRO --}}
<div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 15px;">
            <div class="modal-header text-white" style="background-color: var(--guinda-chiapas); border-radius: 15px 15px 0 0;">
                <h5 class="modal-title fw-bold"><i class="bi bi-pencil-square me-2"></i>Actualizar Información</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editForm" method="POST">
                @csrf @method('PUT')
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-muted">Nombre Completo</label>
                        <input type="text" name="nombre" id="edit_nombre" class="form-control bg-light border-0 shadow-none" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-muted">Área Adscrita</label>
                        <input type="text" name="area" id="edit_area" class="form-control bg-light border-0 shadow-none" required>
                    </div>
                    <div class="row">
                        <div class="col-6 mb-3">
                            <label class="form-label fw-bold small text-muted">Extensión</label>
                            <input type="text" name="extension" id="edit_extension" class="form-control bg-light border-0 shadow-none">
                        </div>
                        <div class="col-6 mb-3">
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
@endcan

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    {{-- FUNCIONALIDAD 1: Búsqueda Dinámica AJAX --}}
    document.addEventListener('DOMContentLoaded', function() {
        const inputBuscar = document.getElementById('input-buscar');
        const tablaBody = document.getElementById('tabla-body');
        const paginacionContainer = document.getElementById('paginacion-container');
        const spinner = document.getElementById('loading-spinner');
        let timeout = null;

        inputBuscar.addEventListener('keyup', function() {
            clearTimeout(timeout);
            spinner.classList.remove('d-none');
            timeout = setTimeout(() => {
                const valor = inputBuscar.value;
                fetch(`{{ route('agenda.index') }}?buscar=${valor}`, {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                })
                .then(response => response.json())
                .then(data => {
                    tablaBody.innerHTML = data.html;
                    paginacionContainer.innerHTML = data.pagination;
                    spinner.classList.add('d-none');
                    initSweetAlert(); {{-- Reiniciar eventos de borrado para nuevas filas --}}
                });
            }, 300);
        });
    });

    {{-- FUNCIONALIDAD 2: Abrir Modal Edición --}}
    function openEditModal(persona) {
        document.getElementById('editForm').action = "/agenda/" + persona.id;
        document.getElementById('edit_nombre').value = persona.nombre;
        document.getElementById('edit_area').value = persona.area;
        document.getElementById('edit_extension').value = persona.extension || '';
        document.getElementById('edit_piso').value = persona.piso || '';
        var myModal = new bootstrap.Modal(document.getElementById('editModal'));
        myModal.show();
    }

    {{-- FUNCIONALIDAD 3: SweetAlert2 para Borrado --}}
    function initSweetAlert() {
        $('.form-eliminar').off('submit').on('submit', function(e) {
            e.preventDefault();
            Swal.fire({
                title: '¿Desea eliminar este registro?',
                text: "Esta acción no se puede deshacer.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#C90166',
                cancelButtonColor: '#009887',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) { this.submit(); }
            });
        });
    }

    $(document).ready(function() {
        initSweetAlert();
        @if(session('status'))
            Swal.fire({
                icon: 'success',
                title: '¡Operación Exitosa!',
                text: '{{ session('status') }}',
                confirmButtonColor: '#C90166',
                timer: 2500
            });
        @endif
    });
</script>

<style>
    .table-hover tbody tr:hover { background-color: rgba(98, 17, 50, 0.02) !important; }
    .page-link { color: var(--guinda-chiapas); border: none; }
    .page-item.active .page-link { background-color: var(--guinda-chiapas) !important; border-color: var(--guinda-chiapas) !important; }
</style>
@endsection