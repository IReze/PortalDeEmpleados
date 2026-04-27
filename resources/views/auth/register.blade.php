@extends('layouts.app')

@section('title', 'Registro de Empleado')

@section('content')
<div class="full-center-container">
    <div class="auth-card">
        
        <div class="register-photo-wrapper">
            <div class="register-avatar-circle">
                <i class="bi bi-person-fill"></i>
                <i class="bi bi-plus-circle-fill"></i>
            </div>
        </div>
        
        <h3 class="fw-bold mb-2">Registro de Empleado</h3>
        <p class="text-muted small mb-4 px-3">Complete los campos para crear su cuenta en el portal institucional.</p>

        <form method="POST" action="{{ route('register') }}" id="registerForm" novalidate>
            @csrf

            <div class="text-start mb-3 px-3">
                <label for="curp" class="form-label fw-bold small text-muted">CURP</label>
                <input id="curp" type="text" 
                       class="form-control @error('curp') is-invalid @enderror" 
                       name="curp" value="{{ old('curp') }}" 
                       required placeholder="Ingrese sus 18 caracteres" 
                       maxlength="18" style="border-radius: 8px; border: 1px solid #ddd;">
                @error('curp')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>

            <div class="text-start mb-3 px-3">
                <label for="email" class="form-label fw-bold small text-muted">Correo Electrónico</label>
                <input id="email" type="email" 
                       class="form-control @error('email') is-invalid @enderror" 
                       name="email" value="{{ old('email') }}" 
                       required placeholder="ejemplo@gmail.com"
                       style="border-radius: 8px; border: 1px solid #ddd;">
                @error('email')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>

            <div class="row px-3">
                <div class="col-md-6 text-start mb-3">
                    <label for="password" class="form-label fw-bold small text-muted">Contraseña</label>
                    <input id="password" type="password" 
                           class="form-control @error('password') is-invalid @enderror" 
                           name="password" required maxlength="15"
                           style="border-radius: 8px; border: 1px solid #ddd;">
                    @error('password')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>
                <div class="col-md-6 text-start mb-3">
                    <label for="password-confirm" class="form-label fw-bold small text-muted">Confirmar</label>
                    <input id="password-confirm" type="password" 
                           class="form-control" name="password_confirmation" 
                           required maxlength="15" style="border-radius: 8px; border: 1px solid #ddd;">
                </div>
            </div>

            <div class="px-3 mb-3">
                <div class="progress mb-2" style="height: 6px; background-color: #eee;">
                    <div id="password-strength-bar" class="progress-bar" style="width: 0%; transition: 0.3s;"></div>
                </div>
                <div id="password-requirements" class="small text-start">
                    <div class="row">
                        <div class="col-6">
                            <div id="req-length" class="text-muted" style="font-size: 0.75rem;"><i class="bi bi-circle me-1"></i> 8-15 caracteres</div>
                            <div id="req-upper" class="text-muted" style="font-size: 0.75rem;"><i class="bi bi-circle me-1"></i> Una mayúscula</div>
                        </div>
                        <div class="col-6">
                            <div id="req-number" class="text-muted" style="font-size: 0.75rem;"><i class="bi bi-circle me-1"></i> Un número</div>
                            <div id="req-symbol" class="text-muted" style="font-size: 0.75rem;"><i class="bi bi-circle me-1"></i> Un símbolo (@$!%*)</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="px-3">
                <button type="submit" id="btnSubmit" class="btn-chiapas-primary mt-3 shadow-sm border-0 w-100" 
                        disabled style="opacity: 0.5; cursor: not-allowed;">
                    Registrarse ahora
                </button>
            </div>

            <div class="mt-4 pt-3 border-top mx-3">
                <p class="small text-muted">
                    ¿Ya tiene una cuenta activa? <br>
                    <a href="{{ route('login') }}" style="color: #1a4731; font-weight: 700; text-decoration: none;">Inicie sesión aquí</a>
                </p>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const password = document.getElementById('password');
    const confirm = document.getElementById('password-confirm');
    const btn = document.getElementById('btnSubmit');
    const bar = document.getElementById('password-strength-bar');

    function check() {
        const val = password.value;
        const conf = confirm.value;

        const rules = {
            len: val.length >= 8 && val.length <= 15,
            up: /[A-Z]/.test(val),
            num: /[0-9]/.test(val),
            sym: /[@$!%*?&]/.test(val) // Validación de símbolos
        };

        // Actualizar UI de requisitos
        updateUI('req-length', rules.len);
        updateUI('req-upper', rules.up);
        updateUI('req-number', rules.num);
        updateUI('req-symbol', rules.sym);

        // Barra de progreso (ahora sobre 4 requisitos)
        const count = Object.values(rules).filter(Boolean).length;
        const percent = (count / 4) * 100;
        bar.style.width = percent + '%';
        
        if(percent <= 25) bar.style.backgroundColor = '#dc3545'; // Rojo
        else if(percent <= 75) bar.style.backgroundColor = '#ffc107'; // Amarillo
        else bar.style.backgroundColor = '#198754'; // Verde

        // Habilitar si los 4 requisitos están OK y las contraseñas coinciden
        if (Object.values(rules).every(Boolean) && val === conf && val !== '') {
            btn.disabled = false;
            btn.style.opacity = "1";
            btn.style.cursor = "pointer";
        } else {
            btn.disabled = true;
            btn.style.opacity = "0.5";
            btn.style.cursor = "not-allowed";
        }
    }

    function updateUI(id, ok) {
        const el = document.getElementById(id);
        if(!el) return;
        const icon = el.querySelector('i');
        el.style.color = ok ? '#198754' : '#6c757d';
        el.style.fontWeight = ok ? 'bold' : 'normal';
        icon.className = ok ? 'bi bi-check-circle-fill me-1' : 'bi bi-circle me-1';
    }

    password.addEventListener('input', check);
    confirm.addEventListener('input', check);
});
</script>

<style>
    .btn-chiapas-primary {
        background-color:var(--verde-chiapas);
        color: white;
        padding: 12px;
        border-radius: 8px;
        font-weight: bold;
        transition: 0.3s;
    }
</style>
@endsection