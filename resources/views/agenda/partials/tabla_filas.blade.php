@forelse($contactos as $persona)
<tr>
    <td class="ps-4">
        <div class="d-flex align-items-center">
            <div class="avatar-circle me-3 shadow-sm" style="background-color: var(--guinda-chiapas); color: white; width: 38px; height: 38px; display: flex; align-items: center; justify-content: center; border-radius: 50%; font-weight: bold; font-size: 0.9rem; flex-shrink: 0;">
                {{ strtoupper(substr($persona->nombre, 0, 1)) }}
            </div>
            <span class="fw-bold text-dark d-block" style="font-size: 0.9rem;">{{ $persona->nombre }}</span>
        </div>
    </td>
    <td style="max-width: 280px;">
        <span class="badge-status bg-normal text-wrap" style="font-size: 0.75rem; text-align: left; display: inline-block; padding: 6px 10px; background-color: rgba(40, 92, 77, 0.1); color: var(--verde-chiapas); border: 1px solid rgba(40, 92, 77, 0.2); border-radius: 6px;">
            {{ $persona->area }}
        </span>
    </td>
    <td class="text-center fw-bold" style="color: var(--guinda-chiapas);">{{ $persona->extension ?? '-' }}</td>
    <td class="text-center text-secondary small">{{ $persona->piso ?? '-' }}</td>
    
    @can('gestionar agenda')
    <td class="text-end pe-4">
        <div class="btn-group shadow-sm border rounded-3 overflow-hidden">
            <button type="button" class="btn btn-sm btn-white border-end" 
                    onclick="openEditModal({{ json_encode($persona) }})" title="Editar">
                <i class="bi bi-pencil-square text-primary"></i>
            </button>
            <form action="{{ route('agenda.destroy', $persona->id) }}" method="POST" class="form-eliminar m-0">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-sm btn-white text-danger" title="Eliminar">
                    <i class="bi bi-trash3-fill"></i>
                </button>
            </form>
        </div>
    </td>
    @endcan
</tr>
@empty
<tr>
    <td colspan="5" class="text-center py-5 text-muted small fw-bold">No se encontraron resultados.</td>
</tr>
@endforelse