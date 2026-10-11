@extends('layouts.app')

@section('content')
<div class="container" style="max-width: 700px; margin-top: 30px;">

    <!-- Botones de Navegación Rápida -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <a href="{{ url('/course-teachers') }}" class="btn btn-secondary btn-sm shadow-sm">
            ← Volver al Listado
        </a>
        <span class="text-muted fw-bold">Módulo de Asignaciones</span>
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

    <!-- Alerta de Advertencia si la API no responde o faltan datos -->
    @if(empty($courseTeacher) || empty($courses) || empty($teachers))
    <div class="alert alert-warning alert-dismissible fade show shadow-sm border-0 mb-4" role="alert">
        <strong>Atención:</strong> No se pudo recuperar toda la información requerida desde la API externa.
    </div>
    @endif

    <!-- Tarjeta del Formulario de Edición -->
    <div class="card shadow border-0">
        <!-- Encabezado con el Verde SENA -->
        <div class="card-header text-white py-3" style="background-color: #39A900;">
            <h4 class="mb-0 fw-bold">✏️ Editar Asignación de Instructor</h4>
        </div>

        <div class="card-body p-4 bg-light">
            <!-- Formulario apuntando a .update con PUT y ID seguro en formato de arreglo -->
            <form action="{{ route('course_teacher.update', $courseTeacher['id'] ?? 0) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Sección: Datos de Asignación -->
                <h5 class="text-success mb-3 border-bottom pb-2">🔗 Reasociar Curso e Instructor</h5>

                <div class="row g-3 mb-4">
                    <!-- Selección de Curso / Ficha -->
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-muted">Curso (Ficha):</label>
                        <select name="course_id" class="form-select shadow-sm @error('course_id') is-invalid @enderror" required>
                            <option value="">Seleccione un curso...</option>
                            @if(!empty($courses) && is_iterable($courses))
                            @foreach($courses as $course)
                            <!-- Comprobación segura con corchetes y soporte para llaves alternativas de API -->
                            <option value="{{ $course['id'] ?? '' }}" @selected(old('course_id', $courseTeacher['course_id'] ?? ($courseTeacher['curse_id'] ?? '' ))==($course['id'] ?? '' ))>
                                Ficha: {{ $course['course_number'] ?? 'Sin número' }} ({{ $course['day'] ?? 'Sin día' }})
                            </option>
                            @endforeach
                            @endif
                        </select>
                        @error('course_id')
                        <div class="invalid-feedback fw-bold">⚠️ {{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Selección de Instructor -->
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-muted">Instructor:</label>
                        <select name="teacher_id" class="form-select shadow-sm @error('teacher_id') is-invalid @enderror" required>
                            <option value="">Seleccione un instructor...</option>
                            @if(!empty($teachers) && is_iterable($teachers))
                            @foreach($teachers as $teacher)
                            <option value="{{ $teacher['id'] ?? '' }}" @selected(old('teacher_id', $courseTeacher['teacher_id'] ?? '' )==($teacher['id'] ?? '' ))>
                                {{ $teacher['name'] ?? 'Instructor sin nombre' }}
                            </option>
                            @endforeach
                            @endif
                        </select>
                        @error('teacher_id')
                        <div class="invalid-feedback fw-bold">⚠️ {{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Botón de Envío -->
                <div class="text-end border-top pt-3">
                    <button type="submit" class="btn btn-success px-4 shadow" style="background-color: #39A900; border: none;">
                        💾 Guardar Asignación
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection