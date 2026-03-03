@extends('layouts.app')

@section('content') {{-- Cambiado de dashboard-content a content para coincidir con tu layout --}}
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-11">
            
            <div class="card shadow-sm border-0 mb-4" style="border-radius: 15px;">
                <div class="card-header bg-white py-3" style="border-bottom: 3px solid #009887;">
                    <h5 class="mb-0 fw-bold" style="color: #009887;">Información del Trabajador</h5>
                </div>
                <div class="card-body p-4">
                    @if (session('status') == 'profile-information-updated')
                        <div class="alert alert-success border-0 shadow-sm mb-4" style="background-color: #e6f5f3; color: #009887;">
                            ¡La información del perfil ha sido actualizada!
                        </div>
                    @endif

                    <form method="POST" action="{{ route('user-profile-information.update') }}">
                        @csrf
                        @method('PUT')

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-muted">Nombre Completo</label>
                                <input type="text" name="name" class="form-control bg-light border-0" value="{{ $user->name }}" readonly>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-muted">Clave de Empleado</label>
                                <input type="text" class="form-control bg-light border-0" value="{{ $empleado->clave_empleado ?? 'No disponible' }}" readonly>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-muted">CURP</label>
                                <input type="text" class="form-control bg-light border-0" value="{{ $user->curp }}" readonly>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-muted">RFC</label>
                                <input type="text" class="form-control bg-light border-0" value="{{ $empleado->rfc ?? 'No disponible' }}" readonly>
                            </div>

                            <div class="col-12"><hr class="my-3 text-muted opacity-25"></div>

                            <div class="col-md-12">
                                <label class="form-label fw-bold small text-muted">Correo Institucional</label>
                                <input type="email" name="email" class="form-control border-success shadow-sm" value="{{ old('email', $user->email) }}" required>
                            </div>
                        </div>

                        <div class="text-end mt-4">
                            <button type="submit" class="btn text-white fw-bold px-4" style="background-color: #009887; border-radius: 8px;">
                                Guardar Correo
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card shadow-sm border-0 mb-4" style="border-radius: 15px;">
                <div class="card-header bg-white py-3" style="border-bottom: 3px solid #C90166;">
                    <h5 class="mb-0 fw-bold" style="color: #C90166;">Seguridad y Contraseña</h5>
                </div>
                <div class="card-body p-4">
                    @if (session('status') == 'password-updated')
                        <div class="alert alert-success border-0 shadow-sm mb-4" style="background-color: #fce8f0; color: #C90166;">
                            ¡Contraseña actualizada correctamente!
                        </div>
                    @endif

                    <form method="POST" action="{{ route('user-password.update') }}">
                        @csrf
                        @method('PUT')

                        <div class="row g-3">
                            <div class="col-md-12">
                                <label class="form-label fw-bold small text-muted">Contraseña Actual</label>
                                <input type="password" name="current_password" class="form-control border-danger" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-muted">Nueva Contraseña</label>
                                <div class="input-group">
                                    <input type="password" id="password" name="password" class="form-control border-danger" required>
                                    <button class="btn btn-outline-secondary" type="button" onclick="toggleVisibility('password', 'eye-1')">
                                        <i class="bi bi-eye" id="eye-1"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-muted">Confirmar Nueva Contraseña</label>
                                <div class="input-group">
                                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control border-danger" required>
                                    <button class="btn btn-outline-secondary" type="button" onclick="toggleVisibility('password_confirmation', 'eye-2')">
                                        <i class="bi bi-eye" id="eye-2"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="text-end mt-4">
                            <button type="submit" class="btn text-white fw-bold px-4" style="background-color: #C90166; border-radius: 8px;">
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