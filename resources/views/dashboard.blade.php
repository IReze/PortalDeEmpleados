@extends('layouts.app')

@section('content')
<div class="container-fluid p-5" style="background-color: #f4f7f6; min-height: 100vh;">
    <div class="mb-4">
        <h5 class="mb-0" style="color: #C90166; font-weight: 500;">Panel de Control</h5>
        <hr style="border-top: 2px solid #C90166; opacity: 1; width: 100%;">
    </div>

    <div class="row g-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm p-5" style="border-radius: 20px;">
                <h2 class="fw-bold" style="color: #009887; font-size: 2.5rem;">Bienvenido al Portal</h2>
                <p class="text-muted fs-5">Gestione su registro de asistencia, Agenda y Avisos.</p>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100 p-4" style="border-radius: 20px;">
                <h4 class="fw-bold mb-4">Avisos o circulares</h4>
                <div class="text-center py-5">
                    <p class="text-muted italic">No hay avisos o circulares.</p>
                </div>
            </div>
        </div>

        
    </div>
</div>
@endsection