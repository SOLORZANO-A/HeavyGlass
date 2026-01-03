@extends('layouts.app')

@section('title', 'Vehicle Details')

@section('content')
    <div class="container-fluid">

        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">Información Vehiculo</h3>

                <div class="card-tools">
                    <a href="{{ route('vehicles.edit', $vehicle) }}" class="btn btn-warning btn-sm">
                        <i class="fas fa-edit"></i> Editar
                    </a>

                    <a href="{{ route('vehicles.index') }}" class="btn btn-secondary btn-sm">
                        Atras
                    </a>
                </div>
            </div>

            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th width="200">Dueño / Clientes</th>
                        <td>{{ $vehicle->client->fullName() }}</td>
                    </tr>
                    <tr>
                        <th>MArca</th>
                        <td>{{ $vehicle->brand }}</td>
                    </tr>
                    <tr>
                        <th>Modelo</th>
                        <td>{{ $vehicle->model }}</td>
                    </tr>
                    <tr>
                        <th>Placa</th>
                        <td>{{ $vehicle->plate }}</td>
                    </tr>
                    <tr>
                        <th>Año</th>
                        <td>{{ $vehicle->year ?? '—' }}</td>
                    </tr>
                    <tr>
                        <th>Color</th>
                        <td>{{ $vehicle->color ?? '—' }}</td>
                    </tr>
                    <tr>
                        <th>Descripción</th>
                        <td>{{ $vehicle->description ?? '—' }}</td>
                    </tr>
                    <tr>
                        <th>Hora de creacion</th>
                        <td>{{ $vehicle->created_at->format('Y-m-d H:i') }}</td>
                    </tr>
                </table>
            </div>

            <div class="card-footer">
                <a href="{{ route('vehicles.index') }}" class="btn btn-secondary">
                    Regresar a la lista
                </a>
            </div>
        </div>

    </div>
@endsection
