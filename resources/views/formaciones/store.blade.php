@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Registrar Nueva Formación</h4>
                </div>
                <div class="card-body">

                    {{-- Muestra los errores de validación si la API los devuelve --}}
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    {{-- El formulario apunta a la ruta store que se conecta con la API --}}
                    <form action="{{ route('formaciones.store') }}" method="POST">
                        @csrf

                        {{-- Nombre --}}
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre de la Formación</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" value="{{ old('nombre') }}" required>
                        </div>

                        {{-- Código --}}
                        <div class="mb-3">
                            <label for="codigo" class="form-label">Código</label>
                            <input type="text" class="form-control" id="codigo" name="codigo" value="{{ old('codigo') }}" required>
                        </div>

                        {{-- Descripción --}}
                        <div class="mb-3">
                            <label for="descripcion" class="form-label">Descripción</label>
                            <textarea class="form-control" id="descripcion" name="descripcion" rows="3">{{ old('descripcion') }}</textarea>
                        </div>

                        {{-- Estado --}}
                        <div class="mb-3">
                            <label for="estado" class="form-label">Estado</label>
                            <select class="form-control" id="estado" name="estado" required>
                                <option value="">Seleccione un estado</option>
                                <option value="abierta" {{ old('estado') == 'abierta' ? 'selected' : '' }}>Abierta</option>
                                <option value="cerrada" {{ old('estado') == 'cerrada' ? 'selected' : '' }}>Cerrada</option>
                                <option value="proxima" {{ old('estado') == 'proxima' ? 'selected' : '' }}>Próxima</option>
                            </select>
                        </div>

                        {{-- Área (Consumido desde la API) --}}
                        <div class="mb-3">
                            <label for="area_id" class="form-label">Área</label>
                            <select class="form-control" id="area_id" name="area_id" required>
                                <option value="">Seleccione un área</option>
                                @php
                                $listaAreas = isset($areas['data']) ? $areas['data'] : $areas;
                                @endphp
                                @foreach ($listaAreas as $area)
                                <option value="{{ $area['id'] }}" {{ old('area_id') == $area['id'] ? 'selected' : '' }}>
                                    {{ $area['name'] ?? $area['nombre'] }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Centro de Formación (Consumido desde la API - Sin la 'n') --}}
                        <div class="mb-3">
                            <label for="trainig_center_id" class="form-label">Centro de Formación</label>
                            <select class="form-control" id="trainig_center_id" name="trainig_center_id" required>
                                <option value="">Seleccione un centro</option>
                                @php
                                $listaCentros = isset($trainingCenters['data']) ? $trainingCenters['data'] : $trainingCenters;
                                @endphp
                                @foreach ($listaCentros as $center)
                                <option value="{{ $center['id'] }}" {{ old('trainig_center_id') == $center['id'] ? 'selected' : '' }}>
                                    {{ $center['name'] ?? $center['nombre'] }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('formaciones.index') }}" class="btn btn-secondary">Cancelar</a>
                            <button type="submit" class="btn btn-success">Guardar Formación</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection