@extends('layouts.app')

@section('title', 'Autenticación de Dos Factores')

@section('content')
<div class="full-center-container">
    <div class="auth-card" x-data="{ recovery: false }">
        
        <div class="user-avatar-circle-lg">
            <svg xmlns="http://www.w3.org/2000/svg" width="55" height="55" fill="currentColor" class="bi bi-shield-check" viewBox="0 0 16 16">
                <path d="M8 3.5a.5.5 0 0 1 .5.5v1.5H10a.5.5 0 0 1 0 1H8.5V8a.5.5 0 0 1-1 0V6.5H6a.5.5 0 0 1 0-1h1.5V4a.5.5 0 0 1 .5-.5z"/>
                <path d="M8 0c-.69 0-1.843.265-2.928.56-1.11.3-2.229.655-2.887.87a1.54 1.54 0 0 0-1.044 1.262c-.596 4.477.787 7.795 2.465 9.99a11.777 11.777 0 0 0 2.517 2.453c.386.273.744.482 1.048.625.28.132.581.24.829.24s.548-.108.829-.24a7.159 7.159 0 0 0 1.048-.625 11.775 11.775 0 0 0 2.517-2.453c1.678-2.195 3.061-5.513 2.465-9.99a1.541 1.541 0 0 0-1.044-1.263 33.476 33.476 0 0 0-2.887-.87C9.843.266 8.69 0 8 0zm0 1.25c.348 0 .852.09 1.41.24a32.27 32.27 0 0 1 2.69.812c.462.162.903.346 1.135.535.229.186.356.418.356.713 0 4.074-1.243 7.195-2.73 9.14a10.78 10.78 0 0 1-2.348 2.266 5.927 5.927 0 0 1-.826.513 5.927 5.927 0 0 1-.826-.513 10.78 10.78 0 0 1-2.348-2.266C4.243 11.095 3 7.974 3 3.88c0-.295.127-.527.356-.713.232-.189.673-.373 1.135-.535a32.27 32.27 0 0 1 2.69-.812c.558-.15 1.062-.24 1.41-.24z"/>
            </svg>
        </div>

        <h3 class="fw-bold mb-2">Verificación de Identidad</h3>
        
        <p class="text-muted small mb-4 px-3" id="instruction-text">
            Por favor, ingrese el código generado por su aplicación de autenticación para continuar.
        </p>

        <form method="POST" action="{{ route('two-factor.login.store') }}">
            @csrf

            <div class="text-start mb-4 px-3">
                <label for="code" class="form-label fw-bold small text-muted" id="label-text">Código de Seguridad</label>
                <div class="input-group shadow-sm" style="border-radius: 8px; overflow: hidden;">
                    <span class="input-group-text bg-light border-0"><i class="bi bi-shield-lock text-muted"></i></span>
                    <input id="code" type="text" 
                           class="form-control border-0 bg-light @error('code') is-invalid @enderror" 
                           name="code" required autocomplete="one-time-code" autofocus
                           placeholder="000000">
                    
                    <input id="recovery_code" type="text" 
                           class="form-control border-0 bg-light d-none @error('recovery_code') is-invalid @enderror" 
                           name="recovery_code" autocomplete="one-time-code"
                           placeholder="Código de recuperación">
                </div>
                @error('code')
                    <span class="invalid-feedback d-block mt-2" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>

            <div class="px-3">
                <button type="submit" class="btn-chiapas-primary shadow-sm border-0 mb-3">
                    Confirmar Código
                </button>
            </div>

            <div class="mt-2 pt-3 border-top mx-3">
                <button type="button" class="btn btn-link text-decoration-none small" 
                        style="color: var(--verde-chiapas); font-weight: 600;"
                        onclick="toggleRecovery()">
                    <span id="toggle-text">¿No tiene acceso a su aplicación? Use un código de recuperación</span>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    let isRecovery = false;
    function toggleRecovery() {
        isRecovery = !isRecovery;
        const codeInput = document.getElementById('code');
        const recoveryInput = document.getElementById('recovery_code');
        const instructionText = document.getElementById('instruction-text');
        const labelText = document.getElementById('label-text');
        const toggleText = document.getElementById('toggle-text');

        if (isRecovery) {
            codeInput.classList.add('d-none');
            codeInput.removeAttribute('name');
            recoveryInput.classList.remove('d-none');
            recoveryInput.setAttribute('name', 'recovery_code');
            instructionText.innerText = 'Ingrese uno de sus códigos de recuperación de emergencia.';
            labelText.innerText = 'Código de Recuperación';
            toggleText.innerText = 'Volver al código de la aplicación';
        } else {
            recoveryInput.classList.add('d-none');
            recoveryInput.removeAttribute('name');
            codeInput.classList.remove('d-none');
            codeInput.setAttribute('name', 'code');
            instructionText.innerText = 'Por favor, ingrese el código generado por su aplicación de autenticación para continuar.';
            labelText.innerText = 'Código de Seguridad';
            toggleText.innerText = '¿No tiene acceso a su aplicación? Use un código de recuperación';
        }
    }
</script>
@endsection