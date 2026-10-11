@extends('layouts.app')

@section('content')
<div class="container" style="max-width: 750px; margin-top: 30px;">

    <!-- Botón para regresar al listado de asignaciones -->
    <div class="mb-3">
        <a href="{{ url('/course-teachers') }}" class="btn btn-secondary btn-sm">
            ← Volver a Asignaciones
        </a>
    </div>

    <!-- Alerta de Advertencia si la API no responde o el registro está vacío -->
    @if(empty($courseTeacher))
    <div class="alert alert-warning alert-dismissible fade show shadow-sm border-0 mb-4" role="alert">
        <strong>Atención:</strong> No se pudo recuperar la información de la asignación desde la API externa.
    </div>
    @endif

    <!-- Tarjeta de Detalle de la Asignación -->
    <div class="card shadow-sm">
        <!-- Encabezado con el color del SENA -->
        <div class="card-header text-white" style="background-color: #39A900;">
            <h4 class="mb-0">Detalle de Asignación Académica</h4>
        </div>

        <div class="card-body">
            <!-- Sección del Instructor -->
            <h5 class="text-success mb-3">👤 Instructor Asignado</h5>
            <div class="row mb-2">
                <div class="col-sm-4 fw-bold text-muted">Nombre Completo:</div>
                <div class="col-sm-8">
                    {{ $courseTeacher['teacher']['name'] ?? 'Instructor no encontrado' }}
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-sm-4 fw-bold text-muted">Correo de Contacto:</div>
                <div class="col-sm-8">
                    @if(!empty($courseTeacher['teacher']['email']))
                    <a href="mailto:{{ $courseTeacher['teacher']['email'] }}">{{ $courseTeacher['teacher']['email'] }}</a>
                    @else
                    -
                    @endif
                </div>
            </div>

            <hr>

            <!-- Sección del Curso / Ficha -->
            <h5 class="text-success mb-3">📖 Ficha / Programa</h5>
            <div class="row mb-2">
                <div class="col-sm-4 fw-bold text-muted">Número de Ficha:</div>
                <div class="col-sm-8">
                    @php
                    $courseNumber = $courseTeacher['course']['course_number'] ?? ($courseTeacher['curse']['course_number'] ?? null);
                    @endphp

                    @if($courseNumber)
                    <span class="badge bg-primary px-2 py-1">N° {{ $courseNumber }}</span>
                    @else
                    <span class="text-danger">Curso no encontrado</span>
                    @endif
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-sm-4 fw-bold text-muted">Jornada Horaria:</div>
                <div class="col-sm-8 text-capitalize">
                    {{ $courseTeacher['course']['day'] ?? ($courseTeacher['curse']['day'] ?? '-') }}
                </div>
            </div>

            <hr>

            <!-- Fechas de Registro -->
            <div class="row mb-1 small text-muted">
                <div class="col-sm-4">Asignado el:</div>
                <div class="col-sm-8">
                    {{ isset($courseTeacher['created_at']) ? date('d/m/Y h:i A', strtotime($courseTeacher['created_at'])) : 'No registra' }}
                </div>
            </div>
        </div>

        <div class="card-footer bg-light text-end">
            <small class="text-muted float-start mt-1">ID Relación: {{ $courseTeacher['id'] ?? 'N/D' }}</small>
        </div>
    </div>
</div>
@endsection