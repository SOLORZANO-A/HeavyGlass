@extends('layouts.app')

@section('title', 'Edit Vehicle')

@section('content')
<<<<<<< HEAD
    <div class="container-fluid">

        <div class="card card-warning">
            <div class="card-header">
                <h3 class="card-title">Editar Vehiculo</h3>
            </div>

            <form action="{{ route('vehicles.update', $vehicle) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="card-body">

                    <div class="form-group">
                        <label>Dueño / Cliente</label>
                        <select name="client_id" class="form-control @error('client_id') is-invalid @enderror">
                            <option value="">-- Selecciona Cliente --</option>
                            @foreach ($clients as $client)
                                <option value="{{ $client->id }}"
                                    {{ old('client_id', $vehicle->client_id) == $client->id ? 'selected' : '' }}>
                                    {{ $client->fullName() }} ({{ $client->document }})
                                </option>
                            @endforeach
                        </select>
                        @error('client_id')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Marca</label>
                                <input type="text" name="brand"
                                    class="form-control @error('brand') is-invalid @enderror"
                                    value="{{ old('brand', $vehicle->brand) }}">
                                @error('brand')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Modelo</label>
                                <input type="text" name="model"
                                    class="form-control @error('model') is-invalid @enderror"
                                    value="{{ old('model', $vehicle->model) }}">
                                @error('model')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Placa</label>
                                <input type="text" name="plate"
                                    class="form-control @error('plate') is-invalid @enderror"
                                    value="{{ old('plate', $vehicle->plate) }}">
                                @error('plate')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Año</label>
                                <input type="number" name="year" class="form-control"
                                    value="{{ old('year', $vehicle->year) }}">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Numero de motor</label>
                                <input type="text" name="engine_number" class="form-control"
                                    value="{{ old('engine_number', $vehicle->engine_number) }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Numero de chasis</label>
                                <input type="text" name="chassis_number" class="form-control"
                                    value="{{ old('chassis_number', $vehicle->chassis_number) }}">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Color</label>
                                <input type="text" name="color" class="form-control"
                                    value="{{ old('color', $vehicle->color) }}">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Descripción</label>
                        <textarea name="description" class="form-control" rows="3">{{ old('description', $vehicle->description) }}</textarea>
                    </div>

                </div>

                <div class="card-footer">
                    <a href="{{ route('vehicles.index') }}" class="btn btn-secondary">
                        Cancelar
                    </a>

                    <button type="submit" class="btn btn-warning">
                        Actualizar
                    </button>
                </div>

            </form>
        </div>

    </div>
=======
<div class="container-fluid">

    <div class="card card-warning">
        <div class="card-header">
            <h3 class="card-title">Editar Vehiculo</h3>
        </div>

        <form action="{{ route('vehicles.update', $vehicle) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="card-body">

                <div class="form-group">
                    <label>Dueño / Cliente</label>
                    <select name="client_id"
                            class="form-control @error('client_id') is-invalid @enderror">
                        <option value="">-- Selecciona Cliente --</option>
                        @foreach ($clients as $client)
                            <option value="{{ $client->id }}"
                                {{ old('client_id', $vehicle->client_id) == $client->id ? 'selected' : '' }}>
                                {{ $client->fullName() }} ({{ $client->document }})
                            </option>
                        @endforeach
                    </select>
                    @error('client_id')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Marca</label>
                            <input type="text"
                                   name="brand"
                                   class="form-control @error('brand') is-invalid @enderror"
                                   value="{{ old('brand', $vehicle->brand) }}">
                            @error('brand')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Modelo</label>
                            <input type="text"
                                   name="model"
                                   class="form-control @error('model') is-invalid @enderror"
                                   value="{{ old('model', $vehicle->model) }}">
                            @error('model')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Placa</label>
                            <input type="text"
                                   name="plate"
                                   class="form-control @error('plate') is-invalid @enderror"
                                   value="{{ old('plate', $vehicle->plate) }}">
                            @error('plate')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Año</label>
                            <input type="number"
                                   name="year"
                                   class="form-control"
                                   value="{{ old('year', $vehicle->year) }}">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Color</label>
                            <input type="text"
                                   name="color"
                                   class="form-control"
                                   value="{{ old('color', $vehicle->color) }}">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>Descripción</label>
                    <textarea name="description"
                              class="form-control"
                              rows="3">{{ old('description', $vehicle->description) }}</textarea>
                </div>

            </div>

            <div class="card-footer">
                <a href="{{ route('vehicles.index') }}" class="btn btn-secondary">
                    Cancelar
                </a>

                <button type="submit" class="btn btn-warning">
                    Actualizar
                </button>
            </div>

        </form>
    </div>

</div>
>>>>>>> 964613b02c73302aea2dc33386313b314db28634
@endsection
