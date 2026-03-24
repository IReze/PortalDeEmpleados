@extends('layouts.app')

@section('title', 'Avisos y Circulares')

@section('content')
<div class="container-fluid p-4">
    <div class="d-flex justify-content-between align-items-center mb-4 p-3 bg-white shadow-sm" style="border-radius: 12px; border-left: 5px solid var(--guinda-chiapas);">
        <div>
            <h4 class="fw-bold mb-0" style="color: var(--guinda-chiapas);">Avisos y Circulares</h4>
            <p class="text-muted small mb-0">Comunicados oficiales del Estado de Chiapas</p>
        </div>
        
        {{-- 1. BOTÓN DE CREACIÓN: Solo visible para quienes pueden 'lanzar avisos' --}}
        @can('lanzar avisos')
        <button class="btn text-white fw-bold shadow-sm" data-bs-toggle="modal" data-bs-target="#modalNuevoAviso" 
                style="background-color: var(--guinda-chiapas); border-radius: 10px;">
            <i class="bi bi-pencil-fill me-2"></i> Redactar Nuevo
        </button>
        @endcan
    </div>

    <div class="row">
        <div class="col-md-12">
            @forelse($avisos as $aviso)
                <div class="card border-0 shadow-sm mb-3" style="border-radius: 15px; transition: 0.3s;">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-start">
                            <div class="d-flex align-items-center">
                                <div class="icon-box me-3 d-flex align-items-center justify-content-center" 
                                     style="width: 55px; height: 55px; border-radius: 12px; background-color: rgba(0, 152, 135, 0.1);">
                                    <i class="bi {{ $aviso->tipo == 'Circular' ? 'bi-file-earmark-text' : 'bi-megaphone' }} fs-3" style="color: var(--verde-chiapas);"></i>
                                </div>
                                <div>
                                    <span class="badge mb-1 px-3 py-2" style="background-color: {{ $aviso->tipo == 'Circular' ? 'var(--guinda-chiapas)' : 'var(--verde-chiapas)' }}; border-radius: 20px;">
                                        {{ $aviso->tipo }}
                                    </span>
                                    <h5 class="fw-bold mb-1 text-dark">{{ $aviso->titulo }}</h5>
                                    <p class="text-muted small mb-0">
                                        <i class="bi bi-calendar3 me-1"></i> Publicado el {{ $aviso->created_at->format('d/m/Y') }}
                                    </p>
                                </div>
                            </div>
                            
                            <div class="d-flex gap-2">
                                @if($aviso->archivo)
                                    <a href="{{ asset('storage/' . $aviso->archivo) }}" target="_blank" 
                                       class="btn btn-sm shadow-sm fw-bold px-3" 
                                       style="background-color: #fff; color: #dc3545; border: 1px solid #dc3545; border-radius: 8px;">
                                        <i class="bi bi-file-earmark-pdf-fill me-1"></i> Ver PDF
                                    </a>
                                @endif

                                <button class="btn btn-light btn-sm border-0" type="button" data-bs-toggle="collapse" data-bs-target="#contenido-{{ $aviso->id }}">
                                    <i class="bi bi-chevron-down text-muted"></i>
                                </button>

                                {{-- 2. BOTÓN DE ELIMINAR: Solo visible para autorizados --}}
                                {{-- Acciones de Gestión: Solo para autorizados --}}
                                @can('lanzar avisos')
                                <div class="d-flex gap-1">
                                    {{-- BOTÓN EDITAR --}}
                                    <button type="button" class="btn btn-sm btn-light text-primary border-0" 
                                            onclick="openEditAvisoModal({{ json_encode($aviso) }})" title="Editar">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>

                                    {{-- BOTÓN ELIMINAR --}}
                                    <form action="{{ route('avisos.destroy', $aviso->id) }}" method="POST" class="form-eliminar-aviso">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-light text-danger border-0" title="Eliminar">
                                            <i class="bi bi-trash3-fill"></i>
                                        </button>
                                    </form>
                                </div>
                                @endcan
                            </div>
                        </div>

                        <div class="collapse mt-3" id="contenido-{{ $aviso->id }}">
                            <hr>
                            <div class="p-3 bg-light rounded-3 text-secondary" style="line-height: 1.7; font-size: 0.95rem;">
                                {!! nl2br(e($aviso->mensaje)) !!}
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="card border-0 shadow-sm p-5 text-center" style="border-radius: 15px;">
                    <i class="bi bi-chat-left-dots text-muted display-1 opacity-25"></i>
                    <h5 class="mt-3 text-muted fw-bold">No hay Comunicados registrados</h5>
                </div>
            @endforelse
            
            <div class="d-flex justify-content-center mt-4">
                {{ $avisos->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>

{{-- 3. MODAL DE CREACIÓN: También envuelto en @can por seguridad visual --}}
@can('lanzar avisos')
<div class="modal fade" id="modalNuevoAviso" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 15px; border: none;">
            <div class="modal-header text-white" style="background-color: var(--guinda-chiapas); border-radius: 15px 15px 0 0;">
                <h5 class="modal-title fw-bold"><i class="bi bi-pencil-fill me-2"></i>Nuevo Comunicado</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('avisos.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body p-4">
                    {{-- ... Contenido del formulario igual al tuyo ... --}}
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-muted">Clasificación</label>
                        <select name="tipo" class="form-select bg-light border-0 shadow-none" required>
                            <option value="Aviso">Aviso (General)</option>
                            <option value="Circular">Circular (Oficial)</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-muted">Título</label>
                        <input type="text" name="titulo" class="form-control bg-light border-0 shadow-none" placeholder="Ej. Suspensión de labores" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-muted">Mensaje</label>
                        <textarea name="mensaje" rows="5" class="form-control bg-light border-0 shadow-none" placeholder="Escriba el contenido aquí..." required></textarea>
                    </div>
                    <div class="mb-0">
                        <label class="form-label fw-bold small text-muted">Adjuntar Documento PDF (Opcional)</label>
                        <input type="file" name="archivo" class="form-control bg-light border-0 shadow-none" accept=".pdf">
                        <small class="text-muted" style="font-size: 0.7rem;">Tamaño máximo: 10MB. Solo formato .pdf</small>
                    </div>
                </div>
                <div class="modal-footer border-0 p-4 pt-0">
                    <button type="button" class="btn btn-light fw-bold px-4" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn text-white fw-bold px-4 shadow-sm" style="background-color: var(--verde-chiapas);">Publicar</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endcan
@can('lanzar avisos')
<div class="modal fade" id="modalEditarAviso" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 15px; border: none;">
            <div class="modal-header text-white" style="background-color: var(--verde-chiapas); border-radius: 15px 15px 0 0;">
                <h5 class="modal-title fw-bold"><i class="bi bi-pencil-square me-2"></i>Editar Comunicado</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="formEditarAviso" method="POST" enctype="multipart/form-data">
                @csrf @method('PUT')
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-muted">Clasificación</label>
                        <select name="tipo" id="edit_tipo" class="form-select bg-light border-0 shadow-none" required>
                            <option value="Aviso">Aviso (General)</option>
                            <option value="Circular">Circular (Oficial)</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-muted">Título</label>
                        <input type="text" name="titulo" id="edit_titulo" class="form-control bg-light border-0 shadow-none" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-muted">Mensaje</label>
                        <textarea name="mensaje" id="edit_mensaje" rows="5" class="form-control bg-light border-0 shadow-none" required></textarea>
                    </div>
                    <div class="mb-0">
                        <label class="form-label fw-bold small text-muted">Reemplazar PDF (Opcional)</label>
                        <input type="file" name="archivo" class="form-control bg-light border-0 shadow-none" accept=".pdf">
                        <small class="text-muted" style="font-size: 0.7rem;">Dejar vacío para mantener el actual.</small>
                    </div>
                </div>
                <div class="modal-footer border-0 p-4 pt-0">
                    <button type="button" class="btn btn-light fw-bold px-4" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn text-white fw-bold px-4 shadow-sm" style="background-color: var(--verde-chiapas);">Actualizar</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endcan
<style>
    .card:hover { transform: translateY(-3px); box-shadow: 0 12px 20px rgba(0,0,0,0.08) !important; }
    .page-link { color: var(--guinda-chiapas); border: none; }
    .page-item.active .page-link { background-color: var(--guinda-chiapas) !important; border-color: var(--guinda-chiapas) !important; }
    .icon-box i { transition: 0.3s; }
    .card:hover .icon-box i { transform: scale(1.1); }
</style>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function openEditAvisoModal(aviso) {
    // Seteamos la ruta dinámica para el UPDATE
    document.getElementById('formEditarAviso').action = "/avisos/" + aviso.id;
    
    // Llenamos los campos
    document.getElementById('edit_titulo').value = aviso.titulo;
    document.getElementById('edit_mensaje').value = aviso.mensaje;
    document.getElementById('edit_tipo').value = aviso.tipo;
    
    // Mostramos el modal
    var editModal = new bootstrap.Modal(document.getElementById('modalEditarAviso'));
    editModal.show();
}
    // Confirmación de Eliminación con tus colores institucionales
    $('.form-eliminar-aviso').submit(function(e) {
        e.preventDefault();
        Swal.fire({
            title: '¿Eliminar este comunicado?',
            text: "El registro se ocultará del portal pero quedará en el histórico.",
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

    // Alerta de éxito
    @if(session('status'))
        Swal.fire({
            icon: 'success',
            title: 'Operación Exitosa',
            text: '{{ session('status') }}',
            confirmButtonColor: '#C90166',
            timer: 3000
        });
    @endif
</script>

@endsection