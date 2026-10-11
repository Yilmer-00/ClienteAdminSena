@extends('layouts.app')

@section('content')
<div class="container" style="max-width: 800px; margin-top: 30px;">
    <!-- Botones de Navegación Rápida -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <a href="{{ url('/teachers') }}" class="btn btn-secondary btn-sm shadow-sm">
            ← Volver
        </a>
        <span class="text-muted fw-bold">Módulo de Instructores</span>
    </div>

    <!-- Alerta de Éxito Estilizada -->
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 mb-4" role="alert" style="border-left: 5px solid #39A900 !important;">
        <strong>¡Éxito!</strong> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <!-- Alerta de Advertencia si la API no responde o está vacía -->
    @if(empty($areas) || empty($trainigCenters))
    <div class="alert alert-warning alert-dismissible fade show shadow-sm border-0 mb-4" role="alert">
        <strong>Atención:</strong> No se pudo recuperar la totalidad de las áreas o centros de formación desde la API externa.
    </div>
    @endif

    <!-- Tarjeta del Formulario -->
    <div class="card shadow border-0">
        <!-- Encabezado con el Verde SENA -->
        <div class="card-header text-white py-3" style="background-color: #39A900;">
            <h4 class="mb-0 fw-bold">+ Registrar Nuevo Instructor</h4>
        </div>
        <div class="card-body p-4 bg-light">
            <form action="{{ route('teacher.store') }}" method="POST">
                @csrf

                <!-- Sección: Información Personal -->
                <h5 class="text-success mb-3 border-bottom pb-2">👤 Datos de Identificación</h5>
                <div class="row g-3 mb-4">
                    <!-- Nombre del Instructor -->
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-muted">Nombre Completo:</label>
                        <input type="text" name="name" class="form-control shadow-sm" value="{{ old('name') }}" placeholder="Ej. Ing. Carlos Alvarado" required>
                    </div>
                    <!-- Email -->
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-muted">Correo Electrónico:</label>
                        <input type="email" name="email" class="form-control shadow-sm" value="{{ old('email') }}" placeholder="calvarado@sena.edu.co" required>
                    </div>
                </div>

                <!-- Sección: Asignación de Sede y Especialidad -->
                <h5 class="text-success mb-3 border-bottom pb-2"> Especialidad y Sede</h5>
                <div class="row g-3 mb-4">
                    <!-- Selector de Área (Consumo Seguro de Array JSON) -->
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-muted">Área de Especialidad:</label>
                        <select name="area_id" class="form-select shadow-sm" required>
                            <option value="">-- Seleccione Área --</option>
                            @if(!empty($areas) && is_iterable($areas))
                            @foreach($areas as $area)
                            <option value="{{ $area['id'] ?? '' }}" {{ old('area_id') == ($area['id'] ?? '') ? 'selected' : '' }}>
                                {{ $area['name'] ?? 'Área sin nombre' }}
                            </option>
                            @endforeach
                            @endif
                        </select>
                    </div>

                    <!-- Selector de Centro de Formación (Consumo Seguro de Array JSON) -->
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-muted">Centro de Formación:</label>

                        <select
                            name="trainig_center_id"
                            id="trainig_center_id"
                            class="form-select"
                            required>
                            <option value="">Seleccione un centro de formación</option>

                            @foreach ($trainigCenters as $center)
                            <option
                                value="{{ $center['id'] }}"
                                {{ old('trainig_center_id') == $center['id'] ? 'selected' : '' }}>
                                {{ $center['name'] }}
                            </option>
                            @endforeach
                        </select>

                    </div>
                </div>

                <!-- Botón de Registro -->
                <div class="text-end border-top pt-3">
                    <button type="submit" class="btn btn-success px-4 shadow" style="background-color: #39A900; border: none;">
                        Guardar Instructor
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection