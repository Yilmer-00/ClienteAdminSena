@extends('layouts.app')

@section('content')
<div class="container" style="max-width: 900px; margin-top: 30px;">

    <!-- Botones de Navegación Rápida -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <span class="text-muted fw-bold">Módulo de Centros</span>
        <a href="{{ route('trainig-center.create') }}" class="btn btn-success btn-sm shadow-sm" style="background-color: #39A900; border: none;">
            ➕ Nuevo Centro de Formación
        </a>
    </div>

    <!-- Alerta de Éxito -->
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 mb-4" role="alert" style="border-left: 5px solid #39A900 !important;">
        <strong>¡Éxito!</strong> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <!-- Tarjeta con la Tabla -->
    <div class="card shadow border-0">
        <div class="card-header text-white py-3" style="background-color: #39A900;">
            <h4 class="mb-0 fw-bold">🏢 Listado de Centros de Formación</h4>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4 py-3 text-muted fw-bold" style="width: 10%;">ID</th>
                            <th class="py-3 text-muted fw-bold" style="width: 40%;">Nombre del Centro</th>
                            <th class="py-3 text-muted fw-bold" style="width: 25%;">Ubicación</th>
                            <th class="py-3 text-center text-muted fw-bold" style="width: 25%;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($trainigCenters as $center)
                        <tr>
                            <td class="ps-4 fw-bold text-secondary">{{ $center['id'] }}</td>
                            <td class="fw-semibold text-dark">{{ $center['name'] }}</td>
                            <td class="text-secondary">
                                <i class="fas fa-map-marker-alt text-success me-1"></i> {{ $center['location'] }}
                            </td>
                            <td class="pe-4 text-center">
                                <div class="d-flex gap-2 justify-content-center">
                                    <a href="{{ route('trainig-center.show', $center['id']) }}" class="btn btn-primary btn-sm shadow-sm">
                                        👁️ Mostrar
                                    </a>
                                    <a href="{{ route('trainig-center.edit', $center['id']) }}" class="btn btn-warning btn-sm text-dark fw-semibold shadow-sm">
                                        ✏️ Editar
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-5 text-muted">
                                <i class="fas fa-building fs-2 mb-3 d-block text-secondary"></i>
                                No hay centros de formación registrados en el sistema.
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