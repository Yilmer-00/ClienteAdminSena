@extends('layouts.app')

@section('content')
<div class="container" style="max-width: 750px; margin-top: 30px;">
    <div class="mb-3">
        <a href="{{ url('/teachers') }}" class="btn btn-secondary btn-sm">← Volver</a>
        @if(!empty($teacher['id']))
        <a href="{{ route('teacher.edit', $teacher['id']) }}" class="btn btn-warning btn-sm">Editar instructor</a>
        @endif
    </div>

    @if(session('success'))
    <div class="alert alert-success" role="alert">
        {{ session('success') }}
    </div>
    @endif

    <!-- Alerta de Advertencia si la API no responde o el instructor está vacío -->
    @if(empty($teacher))
    <div class="alert alert-warning alert-dismissible fade show shadow-sm border-0 mb-4" role="alert">
        <strong>Atención:</strong> No se pudo recuperar la información del instructor desde la API externa.
    </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-header text-white" style="background-color: #39A900;">
            <h4 class="mb-0">Información del Instructor</h4>
        </div>
        <div class="card-body">
            <h5 class="text-success mb-3">Datos de Contacto</h5>
            <div class="row mb-2">
                <div class="col-sm-4 fw-bold text-muted">Nombre Completo:</div>
                <div class="col-sm-8">{{ $teacher['name'] ?? 'Sin nombre' }}</div>
            </div>
            <div class="row mb-3">
                <div class="col-sm-4 fw-bold text-muted">Correo Institucional:</div>
                <div class="col-sm-8">
                    @if(!empty($teacher['email']))
                    <a href="mailto:{{ $teacher['email'] }}">{{ $teacher['email'] }}</a>
                    @else
                    <span class="text-muted">Sin correo</span>
                    @endif
                </div>
            </div>

            <hr>
            <h5 class="text-success mb-3">Asignación Académica</h5>
            <div class="row mb-2">
                <div class="col-sm-4 fw-bold text-muted">Área:</div>
                <div class="col-sm-8">
                    <span class="badge bg-primary">
                        {{ $teacher['area']['name'] ?? ($teacher['area_name'] ?? 'No asignada') }}
                    </span>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-sm-4 fw-bold text-muted">Centro de Formación:</div>
                <div class="col-sm-8">
                    {{ $teacher['trainig_center']['name'] ?? ($teacher['training_center']['name'] ?? 'No asignado') }}
                </div>
            </div>
        </div>
        <div class="card-footer bg-light text-end">
            <small class="text-muted float-start mt-1">ID Instructor: {{ $teacher['id'] ?? 'N/D' }}</small>
        </div>
    </div>
</div>
@endsection