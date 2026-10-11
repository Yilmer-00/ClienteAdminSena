@extends('layouts.app')

@section('content')
<div class="container" style="max-width: 1050px; margin-top: 30px;">

    <!-- Botones de Navegación Rápida -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <span class="text-muted fw-bold">Módulo de Asignaciones</span>
        <!-- Botón que apunta a tu ruta personalizada de registro -->
        <a href="{{ route('course_teacher.create') }}" class="btn btn-success btn-sm shadow-sm" style="background-color: #39A900; border: none;">
            ➕ Asignar Nuevo Instructor
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
    @if(empty($courseTeachers))
    <div class="alert alert-warning alert-dismissible fade show shadow-sm border-0 mb-4" role="alert">
        <strong>Atención:</strong> No se pudo recuperar el listado de asignaciones desde la API externa.
    </div>
    @endif

    <!-- Tarjeta que contiene la Tabla -->
    <div class="card shadow border-0">
        <!-- Encabezado de la Tarjeta con el Verde SENA -->
        <div class="card-header text-white py-3" style="background-color: #39A900;">
            <h4 class="mb-0 fw-bold">📅 Asignación de Instructores a Cursos</h4>
        </div>

        <div class="card-body p-0">
            <!-- Tabla Responsiva -->
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4 py-3 text-muted fw-bold" style="width: 8%;">ID</th>
                            <th class="py-3 text-muted fw-bold" style="width: 22%;">Número de Curso (Ficha)</th>
                            <th class="py-3 text-muted fw-bold" style="width: 15%;">Jornada</th>
                            <th class="py-3 text-muted fw-bold" style="width: 23%;">Instructor Asignado</th>
                            <th class="py-3 text-muted fw-bold" style="width: 17%;">Email Instructor</th>
                            <th class="py-3 text-center text-muted fw-bold" style="width: 15%;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($courseTeachers as $assignment)
                        <tr>
                            <!-- ID -->
                            <td class="ps-4 fw-bold text-secondary">
                                {{ $assignment['id'] ?? '' }}
                            </td>

                            <!-- Número de Ficha (Soporte para múltiples nombres de llaves en JSON: course o curse) -->
                            <td class="fw-bold text-dark">
                                <span class="badge bg-secondary bg-opacity-10 text-dark border px-2 py-1.5">
                                    {{ $assignment['course']['course_number'] ?? ($assignment['curse']['course_number'] ?? 'N/A') }}
                                </span>
                            </td>

                            <!-- Jornada (Day) -->
                            <td class="text-secondary">
                                <i class="far fa-clock text-success me-1"></i>
                                {{ $assignment['course']['day'] ?? ($assignment['curse']['day'] ?? 'N/A') }}
                            </td>

                            <!-- Instructor -->
                            <td class="fw-semibold text-dark">
                                {{ $assignment['teacher']['name'] ?? 'Sin Instructor' }}
                            </td>

                            <!-- Email Instructor -->
                            <td class="text-secondary small text-break">
                                {{ $assignment['teacher']['email'] ?? 'N/A' }}
                            </td>

                            <!-- Botones de Acciones (IDs seguros con arreglos) -->
                            <td class="pe-4 text-center">
                                <div class="d-flex gap-2 justify-content-center align-items-center">

                                    <!-- Botón Mostrar -->
                                    <a href="{{ route('course_teacher.show', $assignment['id'] ?? 0) }}" class="btn btn-primary btn-sm text-white fw-semibold shadow-sm">
                                        Mostrar
                                    </a>

                                    <!-- Botón Editar -->
                                    <a href="{{ route('course_teacher.edit', $assignment['id'] ?? 0) }}" class="btn btn-warning btn-sm text-dark fw-semibold shadow-sm">
                                        Editar
                                    </a>

                                    <!-- Botón Eliminar -->
                                    <form action="{{ route('course_teacher.destroy', $assignment['id'] ?? 0) }}" method="POST" class="d-inline m-0" onsubmit="return confirm('¿Estás seguro de que deseas eliminar esta asignación?');">
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
                        <!-- Mensaje por si la tabla está vacía -->
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="fas fa-link fs-2 mb-3 d-block text-secondary"></i>
                                No hay asignaciones de instructores registradas.
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