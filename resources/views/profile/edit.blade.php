@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-11">
            
            <div class="card shadow-sm border-0 mb-5" style="border-radius: 15px;">
                <div class="card-header bg-white py-3" style="border-bottom: 3px solid var(--verde-chiapas);">
                    <h5 class="mb-0 fw-bold" style="color: var(--verde-chiapas);">Información del Trabajador</h5>
                </div>
                <div class="card-body p-4">
                    @if (session('status') == 'profile-information-updated')
                        <div class="alert alert-success border-0 shadow-sm mb-4" style="background-color: #e6f5f3; color: var(--verde-chiapas);">
                            <i class="bi bi-check-circle-fill me-2"></i> ¡La información del perfil ha sido actualizada!
                        </div>
                    @endif

                    <form method="POST" action="{{ route('user-profile-information.update') }}">
                        @csrf
                        @method('PUT')

                        <div class="row g-4">
                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-muted">Nombre Completo</label>
                                <input type="text" class="form-control bg-light border-0" value="{{ $user->name }}" readonly style="border-radius: 8px;">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-muted">Clave de Empleado</label>
                                <input type="text" class="form-control bg-light border-0" value="{{ $empleado->clave_empleado ?? 'No disponible' }}" readonly style="border-radius: 8px;">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-muted">CURP</label>
                                <input type="text" class="form-control bg-light border-0" value="{{ $user->curp }}" readonly style="border-radius: 8px;">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-muted">RFC</label>
                                <input type="text" class="form-control bg-light border-0" value="{{ $empleado->rfc ?? 'No disponible' }}" readonly style="border-radius: 8px;">
                            </div>

                            <div class="col-12"><hr class="my-3 opacity-25"></div>

                            <div class="col-md-12">
                                <label for="email" class="form-label fw-bold small text-muted">Correo Electronico</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-end-0 text-muted"><i class="bi bi-envelope"></i></span>
                                    <input type="email" name="email" id="email" class="form-control border-start-0 shadow-sm" 
                                           value="{{ old('email', $user->email) }}" required style="border-top-right-radius: 8px; border-bottom-right-radius: 8px;">
                                </div>
                            </div>
                        </div>

                        <div class="text-end mt-4">
                            <button type="submit" class="btn text-white fw-bold px-5" style="background-color: var(--verde-chiapas); border-radius: 8px; transition: 0.3s;">
                                Guardar Correo
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card shadow-sm border-0" style="border-radius: 15px;">
                <div class="card-header bg-white py-3" style="border-bottom: 3px solid var(--guinda-chiapas);">
                    <h5 class="mb-0 fw-bold" style="color: var(--guinda-chiapas);">Seguridad y Contraseña</h5>
                </div>
                <div class="card-body p-4">
                    @if (session('status') == 'password-updated')
                        <div class="alert alert-success border-0 shadow-sm mb-4" style="background-color: #fce8f0; color: var(--guinda-chiapas);">
                            <i class="bi bi-shield-check me-2"></i> ¡Contraseña actualizada correctamente!
                        </div>
                    @endif

                    <form method="POST" action="{{ route('user-password.update') }}">
                        @csrf
                        @method('PUT')

                        <div class="row g-4">
                            <div class="col-md-12">
                                <label class="form-label fw-bold small text-muted">Contraseña Actual</label>
                                <input type="password" name="current_password" class="form-control border-light shadow-sm" required style="border-radius: 8px;">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-muted">Nueva Contraseña</label>
                                <div class="input-group shadow-sm" style="border-radius: 8px; overflow: hidden;">
                                    <input type="password" id="password" name="password" class="form-control border-light" required>
                                    <button class="btn btn-white border-light" type="button" onclick="toggleVisibility('password', 'eye-1')">
                                        <i class="bi bi-eye text-muted" id="eye-1"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-muted">Confirmar Nueva Contraseña</label>
                                <div class="input-group shadow-sm" style="border-radius: 8px; overflow: hidden;">
                                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control border-light" required>
                                    <button class="btn btn-white border-light" type="button" onclick="toggleVisibility('password_confirmation', 'eye-2')">
                                        <i class="bi bi-eye text-muted" id="eye-2"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="text-end mt-4">
                            <button type="submit" class="btn text-white fw-bold px-5" style="background-color: var(--guinda-chiapas); border-radius: 8px; transition: 0.3s;">
                                Actualizar Contraseña
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    function toggleVisibility(inputId, iconId) {
        const input = document.getElementById(inputId);
        const icon = document.getElementById(iconId);
        if (input.type === "password") {
            input.type = "text";
            icon.classList.replace('bi-eye', 'bi-eye-slash');
        } else {
            input.type = "password";
            icon.classList.replace('bi-eye-slash', 'bi-eye');
        }
    }
</script>
@endsection