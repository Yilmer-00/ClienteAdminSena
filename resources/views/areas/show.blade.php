@extends('layouts.app')

@section('content')
<div class="container" style="max-width: 750px; margin-top: 30px;">
    <div class="mb-3">
        <a href="{{ url('/areas/list') }}" class="btn btn-secondary btn-sm">← Volver</a>
    </div>

    <div class="card shadow-sm">
        <div class="card-header text-white" style="background-color: #39A900;">
            <h4 class="mb-0">Información del Área</h4>
        </div>
        <div class="card-body">
            <h5 class="text-success mb-3">Detalles Generales</h5>
            <div class="row mb-2">
                <div class="col-sm-4 fw-bold text-muted">Nombre del Área:</div>
                <div class="col-sm-8">{{ $area['name'] }}</div>
            </div>
        </div>
        <div class="card-footer bg-light text-end">
            <small class="text-muted float-start mt-1">ID Área: {{ $area['id'] }}</small>
        </div>
    </div>
</div>
@endsection