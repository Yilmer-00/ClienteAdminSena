@extends('layouts.app')

@section('content')
<div class="container" style="max-width: 750px; margin-top: 30px;">
    <div class="mb-3">
        <a href="{{ route('trainig-center.index') }}" class="btn btn-secondary btn-sm shadow-sm">← Volver al Listado</a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-header text-white py-3" style="background-color: #39A900;">
            <h4 class="mb-0 fw-bold"> Detalle del Centro de Formación</h4>
        </div>
        <div class="card-body p-4">
            <h5 class="text-success mb-3 border-bottom pb-2"> Información General</h5>

            <div class="row mb-3">
                <div class="col-sm-4 fw-bold text-muted">Nombre del Centro:</div>
                <div class="col-sm-8 fw-semibold text-dark">{{ $trainigCenter['name'] }}</div>
            </div>

            <div class="row mb-2">
                <div class="col-sm-4 fw-bold text-muted">Ubicación:</div>
                <div class="col-sm-8 text-secondary">
                    <i class="fas fa-map-marker-alt text-success me-1"></i> {{ $trainigCenter['location'] }}
                </div>
            </div>
        </div>
        <div class="card-footer bg-light text-end py-3">
            <small class="text-muted float-start mt-1">ID Centro: {{ $trainigCenter['id'] }}</small>
        </div>
    </div>
</div>
@endsection