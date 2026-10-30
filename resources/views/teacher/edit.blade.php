@extends('layouts.app')

@section('content')
<div class="container" style="max-width: 750px; margin-top: 30px;">

    <!-- Botones de Navegación Rápida -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <a href="{{ url('/teachers') }}" class="btn btn-secondary btn-sm shadow-sm">
            ← Volver al Listado
        </a>
        <span class="text-muted fw-bold">Módulo de Instructores</span>
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

    <!-- Alerta de Advertencia si la API no responde -->
    @if(empty($teacher) || empty($areas) || empty($trainigCenters))
    <div class="alert alert-warning alert-dismissible fade show shadow-sm border-0 mb-4" role="alert">
        <strong>Atención:</strong> No se pudo recuperar toda la información requerida desde la API externa.
    </div>
    @endif

    <!-- Tarjeta del Formulario de Edición -->
    <div class="card shadow border-0">
        <!-- Encabezado con el Verde SENA -->
        <div class="card-header text-white py-3" style="background-color: #39A900;">
            <h4 class="mb-0 fw-bold">✏️ Editar Profesor / Instructor</h4>
        </div>

        <div class="card-body p-4 bg-light">
            <!-- Formulario apuntando a .update con PUT y ID seguro -->
            <form action="{{ route('teacher.update', $teacher['id'] ?? 0) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Sección: Información Personal -->
                <h5 class="text-success mb-3 border-bottom pb-2">👤 Información Personal</h5>

                <div class="row g-3 mb-4">
                    <!-- Nombre del Profesor -->
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-muted">Nombre Completo:</label>
                        <input type="text"
                            name="name"
                            class="form-control shadow-sm @error('name') is-invalid @enderror"
                            value="{{ old('name', $teacher['name'] ?? '') }}"
                            placeholder="Ej. Carlos Mario Restrepo"
                            required>
                        @error('name')
                        <div class="invalid-feedback fw-bold">⚠️ {{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Correo Electrónico -->
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-muted">Correo Electrónico:</label>
                        <input type="email"
                            name="email"
                            class="form-control shadow-sm @error('email') is-invalid @enderror"
                            value="{{ old('email', $teacher['email'] ?? '') }}"
                            placeholder="Ej. carlos@sena.edu.co"
                            required>
                        @error('email')
                        <div class="invalid-feedback fw-bold">⚠️ {{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Sección: Asignación Académica y Sede -->
                <h5 class="text-success mb-3 border-bottom pb-2">🏫 Asignación Administrativa</h5>

                <div class="row g-3 mb-4">
                    <!-- Selección de Área -->
                    <select
                        name="area_id"
                        class="form-select @error('area_id') is-invalid @enderror"
                        required>

                        <option value="">Seleccione un área...</option>

                        @foreach($areas as $area)
                        <option
                            value="{{ $area['id'] }}"
                            @selected(
                            old('area_id', $teacher['area_id'] ?? '' )==$area['id']
                            )>
                            {{ $area['name'] }}
                        </option>
                        @endforeach

                    </select>

                    <!-- Selección de Centro de Formación -->
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-muted">
                            Centro de Formación:
                        </label>

                        <select
                            name="trainig_center_id"
                            class="form-select @error('trainig_center_id') is-invalid @enderror"
                            required>

                            <option value="">Seleccione un centro...</option>

                            @foreach($trainigCenters as $center)
                            <option
                                value="{{ $center['id'] }}"
                                @selected(
                                old( 'trainig_center_id' ,
                                $teacher['trainig_center_id'] ?? ''
                                )==$center['id']
                                )>
                                {{ $center['name'] }}
                            </option>
                            @endforeach

                        </select>

                        @error('trainig_center_id')
                        <div class="invalid-feedback fw-bold">
                            ⚠️ {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>

                <!-- Botón de Envío -->
                <div class="text-end border-top pt-3">
                    <button type="submit" class="btn btn-success px-4 shadow" style="background-color: #39A900; border: none;">
                        💾 Actualizar Instructor
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection