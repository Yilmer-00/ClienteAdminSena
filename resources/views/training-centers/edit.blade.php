@extends('layouts.app')

@section('content')
<div class="container py-4" style="max-width: 800px;">

    {{-- Navegación --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <a href="{{ url('/training-centers') }}" class="btn btn-outline-secondary btn-sm shadow-sm">
            <i class="bi bi-arrow-left"></i> Volver al listado
        </a>

        <span class="text-muted fw-bold">
            Módulo de Centros
        </span>
    </div>

    {{-- Mensajes de éxito --}}
    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
    </div>
    @endif

    {{-- Mensajes de error --}}
    @if (session('error'))
    <div class="alert alert-danger shadow-sm" role="alert">
        {{ session('error') }}
    </div>
    @endif

    {{-- Errores de validación --}}
    @if ($errors->any())
    <div class="alert alert-danger shadow-sm border-0 mb-4" style="border-left: 5px solid #dc3545 !important;" role="alert">
        <strong class="d-block mb-2">
            <i class="bi bi-exclamation-triangle"></i>
            Por favor, corrige los siguientes errores:
        </strong>
        <ul class="mb-0 ps-3">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    {{-- Verificación de datos recibidos desde el controlador --}}
    @if (!isset($trainigCenter) || !is_array($trainigCenter) || !isset($trainigCenter['id']) || !isset($trainigCenter['name']) || !isset($trainigCenter['location']))
    <div class="alert alert-warning shadow-sm" role="alert">
        <h5 class="alert-heading">
            <i class="bi bi-exclamation-circle"></i>
            No se pudo cargar el centro de formación
        </h5>
        <p class="mb-3">
            No se recibieron todos los datos necesarios para editar este registro. Verifica la respuesta de la API.
        </p>
        <a href="{{ url('/training-centers') }}" class="btn btn-secondary btn-sm">
            Volver al listado
        </a>
    </div>
    @else

    {{-- Formulario de edición --}}
    <div class="card shadow border-0">
        <div class="card-header text-white py-3" style="background-color: #39A900;">
            <h4 class="mb-0 fw-bold">
                <i class="bi bi-pencil-square"></i>
                Editar Centro de Formación
            </h4>
            <small>Actualiza la información del centro</small>
        </div>

        <div class="card-body p-4 bg-light">
            <form action="{{ route('trainig-center.update', $trainigCenter['id']) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- Nombre --}}
                <div class="mb-4">
                    <label for="name" class="form-label fw-bold text-muted">
                        Nombre del Centro:
                    </label>
                    <input type="text"
                        id="name"
                        name="name"
                        class="form-control shadow-sm @error('name') is-invalid @enderror"
                        value="{{ old('name', $trainigCenter['name']) }}"
                        maxlength="255"
                        required>

                    @error('name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                {{-- Ubicación --}}
                <div class="mb-4">
                    <label for="location" class="form-label fw-bold text-muted">
                        Ubicación / Ciudad:
                    </label>
                    <input type="text"
                        id="location"
                        name="location"
                        class="form-control shadow-sm @error('location') is-invalid @enderror"
                        value="{{ old('location', $trainigCenter['location']) }}"
                        maxlength="255"
                        required>

                    @error('location')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                {{-- Botones --}}
                <div class="d-flex flex-wrap justify-content-end gap-2 border-top pt-3">
                    <a href="{{ url('/training-centers') }}" class="btn btn-outline-secondary">
                        Cancelar
                    </a>
                    <button type="submit" class="btn btn-success px-4 shadow-sm" style="background-color: #39A900; border: none;">
                        <i class="bi bi-save"></i>
                        Actualizar Centro
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif

</div>
@endsection