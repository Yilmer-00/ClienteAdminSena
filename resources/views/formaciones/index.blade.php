@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Listado de Formaciones</h2>
        <a href="{{ route('formaciones.create') }}" class="btn btn-primary">Registrar Nueva Formación</a>
    </div>

    {{-- Mensaje de éxito opcional si rediriges con un flash message --}}
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>Código</th>
                            <th>Nombre</th>
                            <th>Estado</th>
                            <th>Área</th>
                            <th>Centro de Formación</th>
                            <th>Interesados</th>
                            <th>Inscritos</th>
                            <th>Por Evaluar</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        // Maneja de forma segura si la API devuelve los datos dentro de una clave 'data' o directamente como arreglo
                        $listaFormaciones = isset($formaciones['data']) ? $formaciones['data'] : $formaciones;
                        @endphp

                        @forelse($listaFormaciones as $formacion)
                        <tr>
                            <td>{{ $formacion['codigo'] ?? 'N/A' }}</td>
                            <td>{{ $formacion['nombre'] ?? 'N/A' }}</td>
                            <td>
                                @php
                                $estado = $formacion['estado'] ?? '';
                                $badgeClass = match($estado) {
                                'abierta' => 'bg-success',
                                'proxima' => 'bg-warning text-dark',
                                default => 'bg-secondary',
                                };
                                @endphp
                                <span class="badge {{ $badgeClass }}">
                                    {{ ucfirst($estado) }}
                                </span>
                            </td>
                            <td>{{ $formacion['area']['name'] ?? ($formacion['area']['nombre'] ?? 'N/A') }}</td>
                            <td>{{ $formacion['training_center']['name'] ?? ($formacion['training_center']['nombre'] ?? 'N/A') }}</td>
                            <td><span class="badge bg-info text-dark">{{ $formacion['total_interesados'] ?? 0 }}</span></td>
                            <td><span class="badge bg-primary">{{ $formacion['total_inscritos'] ?? 0 }}</span></td>
                            <td><span class="badge bg-warning text-dark">{{ $formacion['total_por_evaluar'] ?? 0 }}</span></td>
                            <td>
                                <a href="{{ route('formaciones.evaluar', $formacion['id']) }}" class="btn btn-sm btn-outline-info">
                                    Evaluar Aspirantes
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center py-4 text-muted">
                                No hay formaciones registradas o no se pudo conectar con la API.
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