@extends('layouts.app')

@section('title', 'Registro de Empleado')

@section('content')
<div class="full-center-container px-3">
    <div class="auth-card">
        {{-- Encabezado con Iconografía Institucional --}}
        <div class="register-photo-wrapper">
            <div class="register-avatar-circle">
                <i class="bi bi-person-fill"></i>
                <i class="bi bi-plus-circle-fill"></i>
            </div>
        </div>
        
        <h3 class="fw-bold mb-2" style="color: var(--oscuro-chiapas);">Registro de Empleado</h3>
        <p class="text-muted small mb-4">Complete los campos para crear su cuenta en el portal.</p>

        <form method="POST" action="{{ route('register') }}" id="registerForm" novalidate>
            @csrf

            <div class="text-start mb-3">
                <label class="fw-bold small text-muted text-uppercase mb-1">CURP</label>
                <input type="text" name="curp" class="form-control @error('curp') is-invalid @enderror" 
                       value="{{ old('curp') }}" required maxlength="18" placeholder="Ingrese sus 18 caracteres">
                @error('curp') <div class="invalid-feedback"><strong>{{ $message }}</strong></div> @enderror
            </div>

            <div class="text-start mb-3">
                <label class="fw-bold small text-muted text-uppercase mb-1">Correo Electrónico</label>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                       value="{{ old('email') }}" required placeholder="ejemplo@chiapas.gob.mx">
                @error('email') <div class="invalid-feedback"><strong>{{ $message }}</strong></div> @enderror
            </div>

            <div class="row g-2 mb-3">
                <div class="col-12 col-md-6 text-start">
                    <label class="fw-bold small text-muted text-uppercase mb-1">Contraseña</label>
                    <input id="password" type="password" name="password" 
                           class="form-control @error('password') is-invalid @enderror" required maxlength="15">
                </div>
                <div class="col-12 col-md-6 text-start">
                    <label class="fw-bold small text-muted text-uppercase mb-1">Confirmar</label>
                    <input id="password-confirm" type="password" name="password_confirmation" 
                           class="form-control" required maxlength="15">
                </div>
            </div>

            <div class="mb-4">
                <div class="progress mb-2" style="height: 7px; border-radius: 10px; background-color: #eee;">
                    <div id="password-strength-bar" class="progress-bar" style="width: 0%; border-radius: 10px; transition: all 0.4s ease;"></div>
                </div>
                <div class="row g-2 text-start" style="font-size: 0.75rem;">
                    <div class="col-6 text-muted" id="req-length"><i class="bi bi-circle me-1"></i> 8-15 caracteres</div>
                    <div class="col-6 text-muted" id="req-upper"><i class="bi bi-circle me-1"></i> Una Mayúscula</div>
                    <div class="col-6 text-muted" id="req-number"><i class="bi bi-circle me-1"></i> Un Número</div>
                    <div class="col-6 text-muted" id="req-symbol"><i class="bi bi-circle me-1"></i> Un Símbolo (@$!%)</div>
                </div>
            </div>

            {{-- Botón con tu clase global .btn-chiapas-primary --}}
            <button type="submit" id="btnSubmit" class="btn-chiapas-primary shadow-sm" disabled 
                    style="opacity: 0.5; cursor: not-allowed; background-color: var(--verde-chiapas) !important; border: none;">
                REGISTRARSE AHORA
            </button>

            <div class="mt-4 pt-3 border-top">
                <p class="small text-muted">¿Ya tiene una cuenta activa? 
                    <a href="{{ route('login') }}" class="fw-bold text-decoration-none" style="color: var(--guinda-chiapas);">Inicie sesión</a>
                </p>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const p = document.getElementById('password');
    const c = document.getElementById('password-confirm');
    const b = document.getElementById('btnSubmit');
    const bar = document.getElementById('password-strength-bar');

    function validate() {
        const v = p.value;
        const cv = c.value;

        const rules = {
            length: v.length >= 8 && v.length <= 15,
            upper: /[A-Z]/.test(v),
            number: /[0-9]/.test(v),
            symbol: /[@$!%*?&]/.test(v)
        };

        // Actualizar Lista de Requisitos
        Object.keys(rules).forEach(key => {
            const el = document.getElementById('req-' + key);
            const icon = el.querySelector('i');
            if (rules[key]) {
                el.style.color = "var(--verde-chiapas)";
                el.classList.add('fw-bold');
                icon.className = 'bi bi-check-circle-fill me-1';
            } else {
                el.style.color = "#6c757d";
                el.classList.remove('fw-bold');
                icon.className = 'bi bi-circle me-1';
            }
        });

        // Lógica de la Barra de Fortaleza
        const strength = Object.values(rules).filter(Boolean).length;
        const pct = (strength / 4) * 100;
        bar.style.width = pct + '%';
        
        if(pct <= 25) bar.style.backgroundColor = "var(--guinda-chiapas)";
        else if(pct <= 75) bar.style.backgroundColor = "var(--dorado-chiapas)";
        else bar.style.backgroundColor = "var(--verde-chiapas)";

        // Habilitar Botón
        const matches = v === cv && v !== '';
        const ready = Object.values(rules).every(Boolean) && matches;

        b.disabled = !ready;
        b.style.opacity = ready ? "1" : "0.5";
        b.style.cursor = ready ? "pointer" : "not-allowed";
    }

    p.addEventListener('input', validate);
    c.addEventListener('input', validate);
});
</script>
@endsection