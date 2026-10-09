@extends('layouts.app')

@section('content')
<div class="container" style="max-width: 1100px; margin-top: 30px;">

    <!-- Botones de Navegación Rápida -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <span class="text-muted fw-bold">Módulo de Gestión de Aprendices</span>
        <a href="{{ route('apprentice.create') }}" class="btn btn-success btn-sm shadow-sm" style="background-color: #39A900; border: none;">
            ➕ Registrar Nuevo Aprendiz
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
        <!-- Encabezado con el Verde SENA -->
        <div class="card-header text-white py-3" style="background-color: #39A900;">
            <h4 class="mb-0 fw-bold">🎓 Listado de Aprendices</h4>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4 py-3 text-muted fw-bold" style="width: 8%;">ID</th>
                            <th class="py-3 text-muted fw-bold" style="width: 20%;">Nombre</th>
                            <th class="py-3 text-muted fw-bold" style="width: 20%;">Email</th>
                            <th class="py-3 text-muted fw-bold" style="width: 15%;">Celular</th>
                            <th class="py-3 text-muted fw-bold" style="width: 12%;">Curso / Ficha</th>
                            <th class="py-3 text-muted fw-bold" style="width: 10%;">Computador</th>
                            <th class="pe-4 py-3 text-center text-muted fw-bold" style="width: 15%;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($apprentices as $apprentice)
                        <tr>
                            <td class="ps-4 fw-bold text-secondary">{{ $apprentice['id'] }}</td>
                            <td class="fw-semibold text-dark">{{ $apprentice['name'] }}</td>
                            <td class="text-secondary">{{ $apprentice['email'] }}</td>
                            <td class="text-secondary">{{ $apprentice['cell_number'] }}</td>
                            <td>
                                <span class="badge bg-light text-dark border">
                                    {{ $apprentice['course']['course_number'] ?? 'N/A' }}
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-light text-success border border-success">
                                    {{ $apprentice['computer']['brand'] ?? 'Sin equipo' }}
                                </span>
                            </td>
                            <td class="pe-4 text-center">
                                <div class="d-flex gap-2 justify-content-center align-items-center">

                                    <!-- Botón Mostrar -->
                                    <a href="{{ route('apprentice.show', $apprentice['id']) }}" class="btn btn-primary btn-sm shadow-sm">
                                        Mostrar
                                    </a>

                                    <!-- Botón Editar -->
                                    <a href="{{ route('apprentice.edit', $apprentice['id']) }}" class="btn btn-warning btn-sm text-dark fw-semibold shadow-sm">
                                        Editar
                                    </a>

                                    <!-- Botón Eliminar -->
                                    <form action="{{ route('apprentice.destroy', $apprentice['id']) }}" method="POST" class="d-inline m-0" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este aprendiz?');">
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
                        <!-- Mensaje si la tabla está vacía -->
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">
                                <span class="fs-2 mb-2 d-block">👨‍🎓</span>
                                No hay aprendices registrados en el sistema.
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