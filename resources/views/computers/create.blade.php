@extends('layouts.app')

@section('content')
<div class="container" style="max-width: 800px; margin-top: 30px;">

    <!-- Botones de Navegación Rápida -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <a href="{{ route('computer.index') }}" class="btn btn-secondary btn-sm shadow-sm">
            ← Volver al Listado
        </a>
        <span class="text-muted fw-bold">Módulo de Inventario</span>
    </div>

    <!-- Alerta de Éxito Estilizada -->
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 mb-4" role="alert" style="border-left: 5px solid #39A900 !important;">
        <strong>¡Éxito!</strong> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <!-- Tarjeta del Formulario -->
    <div class="card shadow border-0">
        <!-- Encabezado con el Verde SENA -->
        <div class="card-header text-white py-3" style="background-color: #39A900;">
            <h4 class="mb-0 fw-bold">💻 Registrar Computador</h4>
        </div>

        <div class="card-body p-4 bg-light">
            <!-- 1. IMPORTANTE: Se agregó enctype="multipart/form-data" -->
            <form action="{{ route('computer.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Sección: Especificaciones del Equipo -->
                <h5 class="text-success mb-3 border-bottom pb-2">📋 Especificaciones del Equipo</h5>

                <div class="row g-3 mb-4">
                    <!-- Número del Computador -->
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-muted">Número de Computador / Plaqueta:</label>
                        <input type="text"
                            name="number"
                            value="{{ old('number') }}"
                            class="form-control shadow-sm @error('number') is-invalid @enderror"
                            placeholder="Ej. COMP-012"
                            required>
                        @error('number')
                        <div class="invalid-feedback fw-bold">
                            ⚠️ {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <!-- Marca (Brand) -->
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-muted">Marca (Brand):</label>
                        <input type="text"
                            name="brand"
                            value="{{ old('brand') }}"
                            class="form-control shadow-sm @error('brand') is-invalid @enderror"
                            placeholder="Ej. HP, Lenovo, Dell"
                            required>
                        @error('brand')
                        <div class="invalid-feedback fw-bold">
                            ⚠️ {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>

                <!-- 2. NUEVA SECCIÓN: Campo para subir la fotografía -->
                <div class="mb-4">
                    <label class="form-label fw-bold text-muted">Fotografía del Computador:</label>
                    <input type="file"
                        name="urlFoto"
                        class="form-control shadow-sm @error('urlFoto') is-invalid @enderror"
                        accept="image/*">
                    <small class="text-muted d-block mt-1">Formatos permitidos: JPEG, PNG, JPG, GIF (Máx. 2MB)</small>
                    @error('urlFoto')
                    <div class="invalid-feedback fw-bold">
                        ⚠️ {{ $message }}
                    </div>
                    @enderror
                </div>

                <!-- Botón de Registro -->
                <div class="text-end border-top pt-3">
                    <button type="submit" class="btn btn-success px-4 shadow" style="background-color: #39A900; border: none;">
                        💾 Guardar Computador
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection