@extends('layouts.app')

@section('content')
<div class="container" style="max-width: 750px; margin-top: 30px;">

    <!-- Botón para regresar al listado -->
    <div class="mb-3">
        <a href="{{ route('apprentice.index') }}" class="btn btn-secondary btn-sm shadow-sm">
            ← Volver al listado
        </a>
    </div>

    <!-- Tarjeta de Detalle del Aprendiz -->
    <div class="card shadow-sm">
        <!-- Encabezado con el color institucional del SENA -->
        <div class="card-header text-white" style="background-color: #39A900;">
            <h4 class="mb-0">Información del Aprendiz</h4>
        </div>

        <div class="card-body">
            <!-- Datos Personales -->
            <h5 class="text-success mb-3">Datos Personales</h5>

            <div class="row mb-2">
                <div class="col-sm-4 fw-bold text-muted">Nombre Completo:</div>
                <div class="col-sm-8">{{ $apprentice['name'] ?? '' }}</div>
            </div>

            <div class="row mb-2">
                <div class="col-sm-4 fw-bold text-muted">Correo Electrónico:</div>
                <div class="col-sm-8">
                    <a href="mailto:{{ $apprentice['email'] ?? '' }}">{{ $apprentice['email'] ?? '' }}</a>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-sm-4 fw-bold text-muted">Número de Celular:</div>
                <div class="col-sm-8">{{ $apprentice['cell_number'] ?? '' }}</div>
            </div>

            <hr>

            <!-- Asignaciones de Estudio y Equipos -->
            <h5 class="text-success mb-3">Asignaciones</h5>

            <div class="row mb-2">
                <div class="col-sm-4 fw-bold text-muted">Curso (Ficha):</div>
                <div class="col-sm-8">
                    @if(!empty($apprentice['course']))
                    <span class="badge bg-primary">Ficha: {{ $apprentice['course']['course_number'] ?? 'N/A' }}</span>
                    <span class="text-secondary">({{ $apprentice['course']['day'] ?? '' }})</span>
                    @else
                    <span class="text-danger">Sin curso asignado</span>
                    @endif
                </div>
            </div>

            <div class="row mb-2">
                <div class="col-sm-4 fw-bold text-muted">Computador Asignado:</div>
                <div class="col-sm-8">
                    @if(!empty($apprentice['computer']))
                    <strong>{{ $apprentice['computer']['brand'] ?? '' }}</strong>
                    <span class="text-muted">(N° {{ $apprentice['computer']['number'] ?? '' }})</span>
                    @else
                    <span class="text-danger">Sin computador asignado</span>
                    @endif
                </div>
            </div>
        </div>

        <!-- Pie de tarjeta para acciones opcionales -->
        <div class="card-footer bg-light text-end">
            <small class="text-muted float-start mt-1">ID Aprendiz: {{ $apprentice['id'] ?? '' }}</small>
        </div>
    </div>
</div>
@endsection