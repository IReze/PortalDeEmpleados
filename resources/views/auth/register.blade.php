@extends('layouts.app')

@section('title', 'Registro de Empleado')

@section('content')
<style>
    .register-wrapper {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: flex-start;
        padding-top: 10px;
        padding-bottom: 80px;
    }
    .register-card {
        background: white;
        border-radius: 12px;
        padding: 40px;
        width: 100%;
        max-width: 480px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.05);
        border: 1px solid #f0f0f0;
        text-align: center;
    }
    .user-avatar-circle {
        width: 90px;
        height: 90px;
        background: linear-gradient(135deg, #009887, #007d6f);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
        color: white;
    }
    .form-control { border-radius: 6px; padding: 12px 15px; border: 1px solid #ddd; }
    .form-control:focus { border-color: #009887; box-shadow: 0 0 0 0.2rem rgba(0, 152, 135, 0.25); }
    .btn-register {
        background-color: #C90166;
        border: none;
        color: white;
        padding: 14px;
        width: 100%;
        border-radius: 6px;
        font-weight: 700;
        margin-top: 10px;
    }
    label { font-weight: 600; color: #444; font-size: 0.85rem; }
</style>

<div class="register-wrapper">
    <div class="register-card">
        <div class="user-avatar-circle">
            <svg xmlns="http://www.w3.org/2000/svg" width="45" height="45" fill="currentColor" viewBox="0 0 16 16">
                <path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7Zm.5-5v1h1a.5.5 0 0 1 0 1h-1v1a.5.5 0 0 1-1 0v-1h-1a.5.5 0 0 1 0-1h1v-1a.5.5 0 0 1 1 0Zm-2-6a3 3 0 1 1-6 0 3 3 0 0 1 6 0ZM8 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4Z"/>
            </svg>
        </div>

        <h3 class="mb-2 fw-bold">Registro de Empleado</h3>
        <p class="text-muted small mb-4">Ingrese sus datos</p>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="text-start mb-3">
                <label for="curp" class="form-label">CURP</label>
                <input id="curp" type="text" class="form-control @error('curp') is-invalid @enderror" name="curp" value="{{ old('curp') }}" required placeholder="18 caracteres" maxlength="18">
                @error('curp')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>

            <div class="text-start mb-3">
                <label for="email" class="form-label">Correo Institucional</label>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required>
                @error('email')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>

            <div class="row">
                <div class="col-md-6 text-start mb-3">
                    <label for="password" class="form-label">Contraseña</label>
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required>
                </div>
                <div class="col-md-6 text-start mb-3">
                    <label for="password-confirm" class="form-label">Confirmar</label>
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                </div>
            </div>

            <button type="submit" class="btn btn-register shadow-sm">Registrarse</button>
        </form>
    </div>
</div>
@endsection