@extends('layouts.app')

@section('content')
<div class="container" style="max-width: 800px; margin-top: 30px;">

    <!-- Botones de Acción Rápida -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <a href="{{ route('apprentice.index') }}" class="btn btn-secondary btn-sm shadow-sm">
            ← Volver al Listado
        </a>
        <span class="text-muted fw-bold">Módulo de Aprendices</span>
    </div>

    <!-- Alerta de Éxito Estilizada -->
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 mb-4" role="alert" style="border-left: 5px solid #39A900 !important;">
        <strong>¡Éxito!</strong> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <!-- Alerta de Errores de Validación -->
    @if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0 mb-4" role="alert">
        <strong>¡Atención!</strong> Por favor corrige los errores en el formulario.
        <ul class="mb-0 mt-2">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <!-- Tarjeta del Formulario -->
    <div class="card shadow border-0">
        <!-- Encabezado con el Verde SENA -->
        <div class="card-header text-white py-3" style="background-color: #39A900;">
            <h4 class="mb-0 fw-bold">📝 Registrar Nuevo Aprendiz</h4>
        </div>

        <div class="card-body p-4 bg-light">
            <form action="{{ route('apprentice.store') }}" method="POST">
                @csrf

                <!-- Sección: Información Personal -->
                <h5 class="text-success mb-3 border-bottom pb-2">👤 Datos Personales</h5>

                <div class="row g-3 mb-4">
                    <!-- Nombre -->
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-muted">Nombre Completo:</label>
                        <input type="text" name="name" value="{{ old('name') }}" class="form-control shadow-sm" placeholder="Ej. Juan Pérez" required>
                    </div>

                    <!-- Email -->
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-muted">Correo Electrónico:</label>
                        <input type="email" name="email" value="{{ old('email') }}" class="form-control shadow-sm" placeholder="ejemplo@misena.edu.co" required>
                    </div>

                    <!-- Celular -->
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-muted">Número de Celular:</label>
                        <input type="text" name="cell_number" value="{{ old('cell_number') }}" class="form-control shadow-sm" placeholder="3001234567" required>
                    </div>
                </div>

                <!-- Sección: Asignaciones -->
                <h5 class="text-success mb-3 border-bottom pb-2">🏫 Ficha y Equipamiento</h5>

                <div class="row g-3 mb-4">
                    <!-- Curso asignado -->
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-muted">Curso Asignado (Ficha):</label>
                        <select name="course_id" class="form-select shadow-sm" required>
                            <option value="">-- Seleccione Curso --</option>
                            @foreach($courses as $course)
                            <option value="{{ $course['id'] }}" {{ old('course_id') == $course['id'] ? 'selected' : '' }}>
                                Ficha: {{ $course['course_number'] ?? 'N/A' }} - {{ $course['day'] ?? '' }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Computador asignado -->
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-muted">Computador Asignado:</label>
                        <select name="computer_id" class="form-select shadow-sm" required>
                            <option value="">-- Seleccione Computador --</option>
                            @foreach($computers as $computer)
                            <option value="{{ $computer['id'] }}" {{ old('computer_id') == $computer['id'] ? 'selected' : '' }}>
                                {{ $computer['brand'] }} (N° {{ $computer['number'] }})
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Botón de Envío -->
                <div class="text-end border-top pt-3">
                    <button type="submit" class="btn btn-success px-4 shadow" style="background-color: #39A900; border: none;">
                        💾 Guardar Aprendiz
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection