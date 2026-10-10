@extends('layouts.app')

@section('content')
<div class="container" style="max-width: 750px; margin-top: 30px;">
    <div class="mb-3">
        <a href="{{ route('course.index') }}" class="btn btn-secondary btn-sm">← Volver al Listado</a>
    </div>

    <div class="card shadow-sm">
        <div class="card-header text-white" style="background-color: #39A900;">
            <h4 class="mb-0">Información del Curso / Ficha</h4>
        </div>
        <div class="card-body">
            <h5 class="text-success mb-3">Detalles de la Ficha</h5>

            <div class="row mb-2">
                <div class="col-sm-4 fw-bold text-muted">Número de Ficha:</div>
                <div class="col-sm-8"><span class="badge bg-primary px-3 py-2 fs-6">N° {{ $course['course_number'] ?? '' }}</span></div>
            </div>

            <div class="row mb-2">
                <div class="col-sm-4 fw-bold text-muted">Jornada / Horario:</div>
                <div class="col-sm-8 text-capitalize">{{ $course['day'] ?? '' }}</div>
            </div>

            <div class="row mb-2">
                <div class="col-sm-4 fw-bold text-muted">Área de Formación:</div>
                <div class="col-sm-8 fw-semibold text-dark">{{ $course['area']['name'] ?? 'Sin área asignada' }}</div>
            </div>

            <div class="row mb-2">
                <div class="col-sm-4 fw-bold text-muted">Centro de Formación:</div>
                <div class="col-sm-8 text-secondary">{{ $course['training_center']['name'] ?? ($course['trainig_center']['name'] ?? 'Sin centro asignado') }}</div>
            </div>
        </div>

        <div class="card-footer bg-light text-end">
            <small class="text-muted float-start mt-1">ID Curso: {{ $course['id'] ?? '' }}</small>
        </div>
    </div>
</div>
@endsection