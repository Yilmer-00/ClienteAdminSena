@extends('layouts.app')

@section('content')
<div class="container" style="max-width: 900px; margin-top: 30px;">

    <!-- Botones de Navegación Rápida -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <span class="text-muted fw-bold">Módulo de Inventario PC</span>
        <a href="{{ route('computer.create') }}" class="btn btn-success btn-sm shadow-sm" style="background-color: #39A900; border: none;">
            + Registrar Computador
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
            <h4 class="mb-0 fw-bold"> Listado de Computadores</h4>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4 py-3 text-muted fw-bold" style="width: 10%;">ID</th>
                            <th class="py-3 text-muted fw-bold" style="width: 25%;">Número de PC</th>
                            <th class="py-3 text-muted fw-bold" style="width: 25%;">Marca</th>
                            <th class="py-3 text-center text-muted fw-bold" style="width: 15%;">Foto</th>
                            <th class="py-3 text-center text-muted fw-bold" style="width: 25%;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($computers as $computer)
                        <tr>
                            <td class="ps-4 fw-bold text-secondary">{{ $computer['id'] }}</td>
                            <td class="fw-semibold text-dark">{{ $computer['number'] }}</td>
                            <td class="text-secondary">{{ $computer['brand'] }}</td>

                            <!-- SECCIÓN DEDICADA A LA IMAGEN CON ZOOM -->
                            <td class="text-center">
                                @if(!empty($computer['urlFoto']))
                                @php
                                // Construye la URL pública del servidor de la API para la imagen
                                $serverUrl = rtrim(str_replace('/v1', '', env('URL_SERVER_API', 'http://localhost')), '/');
                                $imageUrl = $serverUrl . '/storage/' . $computer['urlFoto'];
                                @endphp

                                <!-- Miniatura con cursor pointer y atributos para abrir el modal -->
                                <img src="{{ $imageUrl }}"
                                    alt="Foto PC"
                                    width="60"
                                    class="img-thumbnail rounded shadow-sm"
                                    style="object-fit: cover; height: 50px; cursor: pointer; transition: transform 0.2s;"
                                    data-bs-toggle="modal"
                                    data-bs-target="#imageModal{{ $computer['id'] }}"
                                    title="Haz clic para ampliar la imagen"
                                    onmouseover="this.style.transform='scale(1.05)';"
                                    onmouseout="this.style.transform='scale(1)';">

                                <!-- MODAL PARA CADA IMAGEN -->
                                <div class="modal fade" id="imageModal{{ $computer['id'] }}" tabindex="-1" aria-labelledby="imageModalLabel{{ $computer['id'] }}" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header bg-light">
                                                <h5 class="modal-title fw-bold text-success" id="imageModalLabel{{ $computer['id'] }}">
                                                    Computador N° {{ $computer['number'] }} ({{ $computer['brand'] }})
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body text-center bg-dark p-3">
                                                <img src="{{ $imageUrl }}"
                                                    class="img-fluid rounded shadow-lg"
                                                    style="max-height: 500px; object-fit: contain;"
                                                    alt="Zoom Foto PC">
                                            </div>
                                            <div class="modal-footer bg-light">
                                                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cerrar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- FIN DEL MODAL -->

                                @else
                                <span class="text-muted small fst-italic">Sin foto</span>
                                @endif
                            </td>

                            <td class="pe-4 text-center">
                                <div class="d-flex gap-2 justify-content-center align-items-center">

                                    <!-- Botón Mostrar -->
                                    <a href="{{ route('computer.show', $computer['id']) }}" class="btn btn-primary btn-sm shadow-sm">
                                        Mostrar
                                    </a>

                                    <!-- Botón Editar -->
                                    <a href="{{ route('computer.edit', $computer['id']) }}" class="btn btn-warning btn-sm text-dark fw-semibold shadow-sm">
                                        Editar
                                    </a>

                                    <!-- Botón Eliminar -->
                                    <form action="{{ route('computer.destroy', $computer['id']) }}" method="POST" class="d-inline m-0" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este computador?');">
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
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                <i class="fas fa-laptop fs-2 mb-3 d-block text-secondary"></i>
                                No hay computadores registrados en el inventario.
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