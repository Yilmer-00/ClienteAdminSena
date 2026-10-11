@extends('layouts.app')

@section('content')
<div class="container" style="max-width: 1050px; margin-top: 30px;">

    <!-- Botones de Navegación Rápida -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <span class="text-muted fw-bold">Módulo de Instructores</span>
        <!-- Botón para registrar un nuevo docente -->
        <a href="{{ route('teacher.create') }}" class="btn btn-success btn-sm shadow-sm" style="background-color: #39A900; border: none;">
            ➕ Nuevo Profesor
        </a>
    </div>

    <!-- Alerta de Éxito Estilizada -->
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 mb-4" role="alert" style="border-left: 5px solid #39A900 !important;">
        <strong>¡Éxito!</strong> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <!-- Alerta de Advertencia si la API no responde -->
    @if(empty($teachers))
    <div class="alert alert-warning alert-dismissible fade show shadow-sm border-0 mb-4" role="alert">
        <strong>Atención:</strong> No se pudo recuperar el listado de profesores desde la API externa.
    </div>
    @endif

    <!-- Tarjeta que contiene la Tabla -->
    <div class="card shadow border-0">
        <!-- Encabezado de la Tarjeta con el Verde SENA -->
        <div class="card-header text-white py-3" style="background-color: #39A900;">
            <h4 class="mb-0 fw-bold">👨‍🏫 Listado de Profesores / Instructores</h4>
        </div>

        <div class="card-body p-0">
            <!-- Tabla Responsiva -->
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4 py-3 text-muted fw-bold" style="width: 8%;">ID</th>
                            <th class="py-3 text-muted fw-bold" style="width: 22%;">Nombre</th>
                            <th class="py-3 text-muted fw-bold" style="width: 22%;">Email</th>
                            <th class="py-3 text-muted fw-bold" style="width: 15%;">Área</th>
                            <th class="py-3 text-muted fw-bold" style="width: 18%;">Centro de Formación</th>
                            <th class="py-3 text-center text-muted fw-bold" style="width: 15%;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($teachers as $teacher)
                        <tr>
                            <!-- ID -->
                            <td class="ps-4 fw-bold text-secondary">
                                {{ $teacher['id'] ?? '' }}
                            </td>

                            <!-- Nombre del Docente -->
                            <td class="fw-bold text-dark">
                                {{ $teacher['name'] ?? 'Sin nombre' }}
                            </td>

                            <!-- Email -->
                            <td class="text-secondary text-break">
                                <i class="far fa-envelope text-muted me-1"></i> {{ $teacher['email'] ?? 'Sin correo' }}
                            </td>

                            <!-- Área (Despliegue seguro de relación anidada en array) -->
                            <td class="text-secondary">
                                <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-2 py-1">
                                    {{ $teacher['area']['name'] ?? ($teacher['area_name'] ?? 'Sin Área') }}
                                </span>
                            </td>

                            <!-- Centro de Formación (Despliegue seguro de relación anidada en array) -->
                            <td class="text-secondary small">
                                <i class="fas fa-building text-muted me-1"></i> {{ $teacher['trainig_center']['name'] ?? ($teacher['training_center']['name'] ?? 'Sin Centro') }}
                            </td>

                            <!-- Botones de Acciones -->
                            <td class="pe-4 text-center">
                                <div class="d-flex gap-2 justify-content-center align-items-center">

                                    <!-- Botón Mostrar -->
                                    <a href="{{ route('teacher.show', $teacher['id'] ?? 0) }}" class="btn btn-primary btn-sm shadow-sm">
                                        Mostrar
                                    </a>

                                    <!-- Botón Editar -->
                                    <a href="{{ route('teacher.edit', $teacher['id'] ?? 0) }}" class="btn btn-warning btn-sm text-dark fw-semibold shadow-sm">
                                        Editar
                                    </a>

                                    <!-- Botón Eliminar -->
                                    <form action="{{ route('teacher.destroy', $teacher['id'] ?? 0) }}" method="POST" class="d-inline m-0" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este profesor?');">
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
                        <!-- Mensaje por si aún no hay profesores registrados -->
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="fas fa-user-tie fs-2 mb-3 d-block text-secondary"></i>
                                No hay profesores registrados en el sistema.
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