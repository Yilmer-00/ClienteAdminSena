@extends('layouts.app')

@section('content')
<div class="container" style="max-width: 700px; margin-top: 30px;">

    <!-- Botones de Navegación Rápida -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <a href="{{ route('course.index') }}" class="btn btn-secondary btn-sm shadow-sm">
            ← Volver al Listado
        </a>
        <span class="text-muted fw-bold">Módulo de Cursos</span>
    </div>

    <!-- Alerta de Errores de Validación -->
    @if ($errors->any())
    <div class="alert alert-danger shadow-sm border-0 mb-4" style="border-left: 5px solid #dc3545 !important;">
        <strong class="d-block mb-1">⚠️ Por favor corrige los siguientes errores:</strong>
        <ul class="mb-0 ps-3">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- Tarjeta del Formulario de Edición -->
    <div class="card shadow border-0">
        <!-- Encabezado con el Verde SENA -->
        <div class="card-header text-white py-3" style="background-color: #39A900;">
            <h4 class="mb-0 fw-bold">✏️ Editar Curso (Ficha)</h4>
        </div>

        <div class="card-body p-4 bg-light">
            <!-- Formulario apuntando a .update con PUT -->
            <form action="{{ route('course.update', $course['id'] ?? '') }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Sección: Datos Básicos del Curso -->
                <h5 class="text-success mb-3 border-bottom pb-2">📋 Información General</h5>

                <div class="row g-3 mb-4">
                    <!-- Número de Curso -->
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-muted">Número del Curso (Ficha):</label>
                        <input type="text"
                            name="course_number"
                            class="form-control shadow-sm @error('course_number') is-invalid @enderror"
                            value="{{ old('course_number', $course['course_number'] ?? '') }}"
                            placeholder="Ej. 2554628"
                            required>
                        @error('course_number')
                        <div class="invalid-feedback fw-bold">⚠️ {{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Jornada / Día -->
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-muted">Jornada:</label>
                        <select name="day" class="form-select shadow-sm @error('day') is-invalid @enderror" required>
                            <option value="">Seleccione una jornada...</option>
                            <option value="Diurna" {{ (old('day', $course['day'] ?? '') == 'Diurna') ? 'selected' : '' }}>☀️ Diurna</option>
                            <option value="Nocturna" {{ (old('day', $course['day'] ?? '') == 'Nocturna') ? 'selected' : '' }}>🌙 Nocturna</option>
                            <option value="Mixta" {{ (old('day', $course['day'] ?? '') == 'Mixta') ? 'selected' : '' }}>🔄 Mixta</option>
                        </select>
                        @error('day')
                        <div class="invalid-feedback fw-bold">⚠️ {{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Sección: Relaciones de Negocio -->
                <h5 class="text-success mb-3 border-bottom pb-2">📂 Relaciones del Curso</h5>

                <div class="row g-3 mb-4">
                    <!-- Selección de Área -->
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-muted">Área de Formación:</label>
                        <select name="area_id" class="form-select shadow-sm @error('area_id') is-invalid @enderror" required>
                            <option value="">Seleccione un área...</option>
                            @foreach($areas as $area)
                            <option value="{{ $area['id'] }}" {{ (old('area_id', $course['area_id'] ?? '') == $area['id']) ? 'selected' : '' }}>
                                {{ $area['name'] }}
                            </option>
                            @endforeach
                        </select>
                        @error('area_id')
                        <div class="invalid-feedback fw-bold">⚠️ {{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Selección de Centro de Formación -->
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-muted">Centro de Formación:</label>
                        <select name="training_center_id" class="form-select shadow-sm @error('training_center_id') is-invalid @enderror" required>
                            <option value="">Seleccione un centro...</option>
                            @foreach($trainig_centers as $center)
                            <option value="{{ $center['id'] }}" {{ (old('training_center_id', $course['training_center_id'] ?? '') == $center['id']) ? 'selected' : '' }}>
                                {{ $center['name'] }}
                            </option>
                            @endforeach
                        </select>
                        @error('training_center_id')
                        <div class="invalid-feedback fw-bold">⚠️ {{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Botón de Envío -->
                <div class="text-end border-top pt-3">
                    <button type="submit" class="btn btn-success px-4 shadow" style="background-color: #39A900; border: none;">
                        💾 Actualizar Curso
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection