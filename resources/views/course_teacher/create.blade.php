@extends('layouts.app')

@section('content')




<div class="container" style="max-width: 800px; margin-top: 30px;">

    <!-- Botones de Navegación Rápida -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <a href="{{ url('/course-teachers') }}" class="btn btn-secondary btn-sm shadow-sm">
            ← Volver al inicio
        </a>
        <span class="text-muted fw-bold">Módulo de Asignaciones</span>
    </div>

    <!-- Alerta de Éxito Estilizada -->
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 mb-4" role="alert" style="border-left: 5px solid #39A900 !important;">
        <strong>¡Éxito!</strong> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <!-- Alerta de Advertencia si la API no responde -->
    @if(empty($courses) || empty($teachers))
    <div class="alert alert-warning alert-dismissible fade show shadow-sm border-0 mb-4" role="alert">
        <strong>Atención:</strong> No se pudo recuperar la totalidad de los cursos o instructores desde la API externa.
    </div>
    @endif

    <!-- Tarjeta del Formulario -->
    <div class="card shadow border-0">
        <!-- Encabezado con el Verde SENA -->
        <div class="card-header text-white py-3" style="background-color: #39A900;">
            <h4 class="mb-0 fw-bold">🔗 Asignar Instructor a un Curso</h4>
        </div>

        <div class="card-body p-4 bg-light">
            <form action="{{ route('course_teacher.store') }}" method="POST">
                @csrf

                <!-- Sección: Datos de Vinculación -->
                <h5 class="text-success mb-3 border-bottom pb-2">📋 Selección de Curso y Docente</h5>

                <div class="row g-3 mb-4">
                    <!-- Selector de Curso -->
                    <div class="col-md-6">
                        <label for="course_id" class="form-label fw-bold text-muted">Curso (Ficha):</label>
                        <select name="course_id" id="course_id" class="form-select shadow-sm @error('course_id') is-invalid @enderror" required>
                            <option value="">-- Seleccione un curso --</option>
                            @if(!empty($courses) && is_iterable($courses))
                            @foreach ($courses as $course)
                            <option value="{{ $course['id'] ?? '' }}" @selected(old('course_id')==($course['id'] ?? '' ))>
                                Ficha: {{ $course['course_number'] ?? 'Sin número' }}
                            </option>
                            @endforeach
                            @endif
                        </select>
                        @error('course_id')
                        <div class="invalid-feedback fw-bold">⚠️ {{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Selector de Docente -->
                    <div class="col-md-6">
                        <label for="teacher_id" class="form-label fw-bold text-muted">Docente / Instructor:</label>
                        <select name="teacher_id" id="teacher_id" class="form-select shadow-sm @error('teacher_id') is-invalid @enderror" required>
                            <option value="">-- Seleccione un docente --</option>
                            @if(!empty($teachers) && is_iterable($teachers))
                            @foreach ($teachers as $teacher)
                            <option value="{{ $teacher['id'] ?? '' }}" @selected(old('teacher_id')==($teacher['id'] ?? '' ))>
                                {{ $teacher['name'] ?? 'Sin nombre' }}
                            </option>
                            @endforeach
                            @endif
                        </select>
                        @error('teacher_id')
                        <div class="invalid-feedback fw-bold"> {{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Botón de Envío -->
                <div class="text-end border-top pt-3">
                    <button type="submit" class="btn btn-success px-4 shadow" style="background-color: #39A900; border: none;">
                        Guardar Asignación
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection