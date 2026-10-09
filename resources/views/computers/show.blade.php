@extends('layouts.app')

@section('content')
<div class="container" style="max-width: 750px; margin-top: 30px;">
    <div class="mb-3">
        <a href="{{ route('computer.index') }}" class="btn btn-secondary btn-sm shadow-sm">← Volver al Listado</a>
    </div>

    <div class="card shadow-sm border-0">
        <!-- Encabezado con el Verde SENA -->
        <div class="card-header text-white py-3" style="background-color: #39A900;">
            <h4 class="mb-0 fw-bold"> Especificaciones del Computador</h4>
        </div>

        <div class="card-body p-4">
            <h5 class="text-success mb-3 border-bottom pb-2">📋 Datos del Equipo</h5>

            <div class="row mb-3">
                <div class="col-sm-4 fw-bold text-muted">Marca / Fabricante:</div>
                <div class="col-sm-8"><strong>{{ $computer['brand'] }}</strong></div>
            </div>

            <div class="row mb-3">
                <div class="col-sm-4 fw-bold text-muted">Número de Inventario:</div>
                <div class="col-sm-8"><span class="badge bg-dark fs-6">N° {{ $computer['number'] }}</span></div>
            </div>

            <!-- SECCIÓN DE LA FOTOGRAFÍA DEL COMPUTADOR -->
            <div class="row mb-2">
                <div class="col-sm-4 fw-bold text-muted">Fotografía del Equipo:</div>
                <div class="col-sm-8">
                    @if(!empty($computer['urlFoto']))
                    @php
                    // Construye la URL pública del servidor de la API para la imagen
                    $serverUrl = rtrim(str_replace('/v1', '', env('URL_SERVER_API', 'http://localhost')), '/');
                    $imageUrl = $serverUrl . '/storage/' . $computer['urlFoto'];
                    @endphp
                    <div class="mt-1">
                        <img src="{{ $imageUrl }}"
                            alt="Foto del Computador {{ $computer['number'] }}"
                            class="img-fluid rounded shadow-sm border"
                            style="max-height: 250px; object-fit: cover;">
                    </div>
                    @else
                    <span class="text-muted fst-italic">Este equipo no cuenta con una fotografía registrada.</span>
                    @endif
                </div>
            </div>

        </div>

        <div class="card-footer bg-light text-end py-3">
            <small class="text-muted float-start mt-1">ID Equipo: {{ $computer['id'] }}</small>
        </div>
    </div>
</div>
@endsection