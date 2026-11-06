@extends('layouts.app')

@section('content')
<div class="container" style="max-width: 1000px; margin-top: 30px;">

    {{-- Encabezado y navegación --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h5 class="fw-bold mb-1">Módulo de Inventario PC</h5>
            <small class="text-muted">Administración de computadores registrados</small>
        </div>

        <a href="{{ route('computer.create') }}"
            class="btn btn-success btn-sm shadow-sm"
            style="background-color: #39A900; border: none;">
            + Registrar Computador
        </a>
    </div>

    {{-- Mensaje de éxito --}}
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 mb-4"
        role="alert"
        style="border-left: 5px solid #39A900 !important;">
        <strong>¡Éxito!</strong> {{ session('success') }}
        <button type="button" class="btn-close"
            data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    {{-- Mensaje de errores --}}
    @if($apiError)
    <div class="alert alert-danger shadow-sm" role="alert">
        {{ $apiError }}
    </div>
    @endif

    @if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show shadow-sm">
        <strong>No se pudo completar la operación:</strong>
        <ul class="mb-0 mt-2">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close"
            data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    {{-- Tabla de computadores --}}
    <div class="card shadow-sm border-0">

        <div class="card-header text-white py-3"
            style="background-color: #39A900;">
            <h5 class="mb-0 fw-bold">
                <i class="fas fa-laptop me-2"></i>
                Listado de Computadores
            </h5>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">

                <table class="table table-hover align-middle mb-0">

                    <thead class="table-light">
                        <tr>
                            <th class="ps-4 py-3">ID</th>
                            <th class="py-3">Número de PC</th>
                            <th class="py-3">Marca</th>
                            <th class="py-3 text-center">Imagen</th>
                            <th class="py-3 text-center">Acciones</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($computers as $computer)

                        <tr>
                            <td class="ps-4 fw-bold text-secondary">
                                {{ $computer['id'] }}
                            </td>

                            <td class="fw-semibold">
                                {{ $computer['number'] }}
                            </td>

                            <td class="text-secondary">
                                {{ $computer['brand'] }}
                            </td>

                            {{-- Imagen de Cloudinary --}}
                            <td class="text-center">
                                @php
                                $imageUrl = $computer['imagen_url'] ?? null;
                                if (empty($imageUrl) && !empty($computer['urlFoto'])) {
                                    $imageUrl = $computer['urlFoto'];
                                    if (!str_starts_with($imageUrl, 'http://') && !str_starts_with($imageUrl, 'https://')) {
                                        $serverUrl = rtrim(str_replace('/v1', '', config('services.api.url', '')), '/');
                                        $imageUrl = $serverUrl . '/storage/' . ltrim($imageUrl, '/');
                                    }
                                }
                                @endphp
                                @if(!empty($imageUrl))
                                <img
                                    src="{{ $imageUrl }}"
                                    alt="Computador {{ $computer['number'] }}"
                                    class="rounded shadow-sm border"
                                    style="width: 85px; height: 65px; object-fit: cover;"
                                    loading="lazy"
                                    onerror="this.style.display='none'; this.nextElementSibling.style.display='inline-flex';">

                                <span class="badge bg-secondary"
                                    style="display: none;">
                                    Sin imagen
                                </span>
                                @else
                                <span class="badge bg-secondary">
                                    Sin imagen
                                </span>
                                @endif
                            </td>

                            {{-- Acciones --}}
                            <td class="text-center pe-3">
                                <div class="d-flex gap-2 justify-content-center">

                                    <a href="{{ route('computer.show', $computer['id']) }}"
                                        class="btn btn-primary btn-sm shadow-sm">
                                        <i class="fas fa-eye"></i>
                                    </a>

                                    <a href="{{ route('computer.edit', $computer['id']) }}"
                                        class="btn btn-warning btn-sm shadow-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <form action="{{ route('computer.destroy', $computer['id']) }}"
                                        method="POST"
                                        class="d-inline m-0"
                                        onsubmit="return confirm('¿Estás seguro de que deseas eliminar este computador?');">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                            class="btn btn-danger btn-sm shadow-sm">
                                            <i class="fas fa-trash"></i>
                                        </button>

                                    </form>

                                </div>
                            </td>
                        </tr>

                        @empty

                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                <i class="fas fa-laptop fs-2 mb-3 d-block"></i>
                                No hay computadores registrados en el inventario.
                            </td>
                        </tr>

                        @endforelse
                    </tbody>

                </table>

            </div>
        </div>

        <div class="card-footer bg-white text-muted small">
            Total de computadores:
            <strong>{{ count($computers) }}</strong>
        </div>

    </div>
</div>
@endsection