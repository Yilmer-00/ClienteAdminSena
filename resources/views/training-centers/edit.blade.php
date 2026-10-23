@extends('layouts.app')

@section('content')
<div class="container" style="max-width: 800px; margin-top: 30px;">

    <!-- Botón de retorno -->
    <div class="mb-3">
        <a href="{{ route('trainig-center.index') }}" class="btn btn-secondary btn-sm shadow-sm">
            ← Cancelar y Volver
        </a>
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

    <!-- Tarjeta del Formulario -->
    <div class="card shadow border-0">
        <!-- Encabezado con el Verde SENA e Icono -->
        <div class="card-header text-white py-3" style="background-color: #39A900;">
            <h4 class="mb-0 fw-bold"><i class="bi bi-pencil-square"></i> Actualizar Centro de Formación</h4>
        </div>

        <div class="card-body p-4 bg-light">
            <form action="{{ route('trainig-center.update', $trainigCenter['id']) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Sección: Información del Centro -->
                <h5 class="text-success mb-3 border-bottom pb-2">🏢 Información del Centro</h5>

                <div class="row g-3 mb-4">
                    <!-- Nombre del Centro -->
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-muted">Nombre del Centro:</label>
                        <input type="text"
                            name="name"
                            class="form-control shadow-sm @error('name') is-invalid @enderror"
                            value="{{ old('name', $trainigCenter['name'] ?? '') }}"
                            placeholder="Ej. Centro de Comercio y Servicios"
                            required>
                        @error('name')
                        <div class="invalid-feedback fw-bold">⚠️ {{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Ubicación del Centro -->
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-muted">Ubicación / Ciudad:</label>
                        <input type="text"
                            name="location"
                            class="form-control shadow-sm @error('location') is-invalid @enderror"
                            value="{{ old('location', $trainigCenter['location'] ?? '') }}"
                            placeholder="Ej. Popayán, Cauca"
                            required>
                        @error('location')
                        <div class="invalid-feedback fw-bold">⚠️ {{ $message }}</div>
                        @enderror
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