@extends('layouts.app')

@section('content')
<div class="container" style="max-width: 1000px; margin-top: 30px;">

    <!-- Botones de Navegación Rápida -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <span class="text-muted fw-bold">Módulo de Cursos (Fichas)</span>
        <!-- Botón para ir al formulario de creación con estilo verde SENA -->
        <a href="{{ route('course.create') }}" class="btn btn-success btn-sm shadow-sm" style="background-color: #39A900; border: none;">
            ➕ Registrar Nuevo Curso
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
        <!-- Encabezado de la Tarjeta con el Verde SENA -->
        <div class="card-header text-white py-3" style="background-color: #39A900;">
            <h4 class="mb-0 fw-bold">📋 Listado de Cursos</h4>
        </div>

        <div class="card-body p-0">
            <!-- Tabla Responsiva -->
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4 py-3 text-muted fw-bold" style="width: 8%;">ID</th>
                            <th class="py-3 text-muted fw-bold" style="width: 18%;">Número de Curso</th>
                            <th class="py-3 text-muted fw-bold" style="width: 15%;">Jornada</th>
                            <th class="py-3 text-muted fw-bold" style="width: 20%;">Área</th>
                            <th class="py-3 text-muted fw-bold" style="width: 22%;">Centro de Formación</th>
                            <th class="py-3 text-center text-muted fw-bold" style="width: 17%;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($courses as $course)
                        <tr>
                            <!-- ID del Curso -->
                            <td class="ps-4 fw-bold text-secondary">
                                {{ $course['id'] ?? '' }}
                            </td>

                            <!-- Número de Ficha -->
                            <td class="fw-bold text-dark">
                                <span class="badge bg-secondary bg-opacity-10 text-dark border px-2 py-1.5">
                                    {{ $course['course_number'] ?? '' }}
                                </span>
                            </td>

                            <!-- Jornada (Day) -->
                            <td class="text-secondary">
                                <i class="far fa-clock text-success me-1"></i> {{ $course['day'] ?? '' }}
                            </td>

                            <!-- Área -->
                            <td class="text-secondary fw-semibold">
                                {{ $course['area']['name'] ?? 'Sin área' }}
                            </td>

                            <!-- Centro de Formación -->
                            <td class="text-secondary small">
                                <i class="fas fa-building text-muted me-1"></i> {{ $course['training_center']['name'] ?? ($course['trainig_center']['name'] ?? 'Sin centro') }}
                            </td>

                            <!-- Botones de Acciones -->
                            <td class="pe-4 text-center">
                                <div class="d-flex gap-2 justify-content-center align-items-center">

                                    <!-- Botón Mostrar -->
                                    <a href="{{ route('course.show', $course['id']) }}" class="btn btn-primary btn-sm shadow-sm">
                                        Mostrar
                                    </a>

                                    <!-- Botón Editar -->
                                    <a href="{{ route('course.edit', $course['id']) }}" class="btn btn-warning btn-sm text-dark fw-semibold shadow-sm">
                                        Editar
                                    </a>

                                    <!-- Botón Eliminar -->
                                    <form action="{{ route('course.destroy', $course['id']) }}" method="POST" class="d-inline m-0" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este curso?');">
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
                        <!-- Mensaje por si aún no hay cursos registrados -->
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="fas fa-graduation-cap fs-2 mb-3 d-block text-secondary"></i>
                                No hay cursos ni fichas registradas en el sistema.
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