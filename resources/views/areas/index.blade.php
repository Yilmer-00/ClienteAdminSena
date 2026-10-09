@extends('layouts.app')

@section('content')
<div class="container" style="max-width: 900px; margin-top: 30px;">

    <!-- Botones de Navegación Rápida -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <span class="text-muted fw-bold">Módulo de Áreas</span>
        <!-- Botón para ir al formulario de creación -->
        <a href="{{ route('area.create') }}" class="btn btn-success btn-sm shadow-sm" style="background-color: #39A900; border: none;">
            ➕ Registrar Nueva Área
        </a>
    </div>

    <!-- Alerta de Éxito Estilizada -->
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 mb-4" role="alert" style="border-left: 5px solid #39A900 !important;">
        <strong>¡Éxito!</strong> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <!-- Tarjeta que contiene la Tabla -->
    <div class="card shadow border-0">
        <!-- Encabezado de la Tarjeta -->
        <div class="card-header text-white py-3" style="background-color: #39A900;">
            <h4 class="mb-0 fw-bold">📋 Listado de Áreas Registradas</h4>
        </div>

        <div class="card-body p-0">
            <!-- Tabla Responsiva -->
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4 py-3 text-muted fw-bold" style="width: 10%;">ID</th>
                            <th class="py-3 text-muted fw-bold" style="width: 60%;">Nombre del Área</th>
                            <th class="py-3 text-center text-muted fw-bold" style="width: 30%;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($areas as $area)
                        <tr>
                            <!-- ID del Área -->
                            <td class="ps-4 fw-bold text-secondary">
                                {{ $area['id'] }}
                            </td>

                            <!-- Nombre del Área -->
                            <td class="fw-semibold text-dark">
                                {{ $area['name'] }}
                            </td>

                            <!-- Botones de Acciones Conectados -->
                            <td class="pe-4">
                                <div class="d-flex gap-2 justify-content-center align-items-center">

                                    <!-- Botón Mostrar -->
                                    <a href="{{ route('area.show', $area['id']) }}" class="btn btn-primary btn-sm shadow-sm">
                                        Mostrar
                                    </a>

                                    <!-- Botón Editar -->
                                    <a href="{{ route('area.edit', $area['id']) }}" class="btn btn-warning btn-sm text-dark fw-semibold shadow-sm">
                                        Editar
                                    </a>

                                    <!-- Botón Eliminar -->
                                    <form action="{{ route('area.destroy', $area['id']) }}" method="POST" class="d-inline m-0" onsubmit="return confirm('¿Estás seguro de que deseas eliminar esta área?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm shadow-sm">
                                            Eliminar
                                        </button>
                                    </form>

                                </div>
                            </td>
                        </tr>
                        @empty
                        <!-- Mensaje por si aún no hay áreas registradas -->
                        <tr>
                            <td colspan="3" class="text-center py-5 text-muted">
                                <i class="fas fa-folder-open fs-2 mb-3 d-block text-secondary"></i>
                                No hay áreas registradas en el sistema.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection