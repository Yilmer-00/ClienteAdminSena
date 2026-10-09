@extends('layouts.app')

@section('content')
<div class="container" style="max-width: 800px; margin-top: 30px;">

    <!-- Botón de retorno -->
    <div class="mb-3">
        <a href="{{ route('apprentice.index') }}" class="btn btn-secondary btn-sm shadow-sm">
            ← Cancelar y Volver
        </a>
    </div>

    <!-- Tarjeta del Formulario -->
    <div class="card shadow border-0">
        <!-- Encabezado elegante con el verde SENA -->
        <div class="card-header text-white py-3" style="background-color: #39A900;">
            <h4 class="mb-0 fw-bold"><i class="bi bi-pencil-square"></i> Actualizar Datos del Aprendiz</h4>
        </div>

        <div class="card-body p-4 bg-light">
            <form action="{{ route('apprentice.update', $apprentice['id']) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Sección: Información Personal -->
                <h5 class="text-success mb-3 border-bottom pb-2">👤 Información Personal</h5>

                <div class="row g-3 mb-4">
                    <!-- Campo Nombre -->
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-muted">Nombre Completo:</label>
                        <input type="text" name="name" class="form-control shadow-sm"
                            value="{{ old('name', $apprentice['name'] ?? '') }}" required>
                    </div>

                    <!-- Campo Email -->
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-muted">Correo Electrónico:</label>
                        <input type="email" name="email" class="form-control shadow-sm"
                            value="{{ old('email', $apprentice['email'] ?? '') }}" required>
                    </div>

                    <!-- Campo Número de Celular -->
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-muted">Número de Celular:</label>
                        <input type="text" name="cell_number" class="form-control shadow-sm"
                            value="{{ old('cell_number', $apprentice['cell_number'] ?? '') }}" required>
                    </div>
                </div>

                <!-- Sección: Asignaciones Colectivas -->
                <h5 class="text-success mb-3 border-bottom pb-2">🏫 Asignaciones del Sistema</h5>

                <div class="row g-3 mb-4">
                    <!-- Selector Curso asignado -->
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-muted">Curso Asignado (Ficha):</label>
                        <select name="course_id" class="form-select shadow-sm" required>
                            <option value="">-- Seleccione Curso --</option>
                            @foreach($courses as $course)
                            <option value="{{ $course['id'] }}" {{ (old('course_id', $apprentice['course_id'] ?? '') == $course['id']) ? 'selected' : '' }}>
                                Ficha: {{ $course['course_number'] ?? 'N/A' }} - {{ $course['day'] ?? '' }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Selector Computador asignado -->
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-muted">Computador Asignado:</label>
                        <select name="computer_id" class="form-select shadow-sm" required>
                            <option value="">-- Seleccione Computador --</option>
                            @foreach($computers as $computer)
                            <option value="{{ $computer['id'] }}" {{ (old('computer_id', $apprentice['computer_id'] ?? '') == $computer['id']) ? 'selected' : '' }}>
                                {{ $computer['brand'] ?? 'Genérico' }} (N° {{ $computer['number'] ?? 'S/N' }})
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Botones de Acción al pie -->
                <div class="text-end border-top pt-3">
                    <button type="submit" class="btn btn-success px-4 shadow" style="background-color: #39A900; border: none;">
                        💾 Guardar Cambios
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection