@extends('layouts.app')

@section('title', 'Vehicles')

@section('content')
    <div class="container-fluid">

        <div class="card">
            <div class="card-header">
<<<<<<< HEAD
                <h3 class="card-title">
                    <i class="fas fa-car"></i> Lista de Vehículos
                </h3>
            </div>

            <div class="row mb-3 align-items-center">

                <!-- Buscador -->
                <div class="col-md-8">
                    <div class="input-group">
                        <span class="input-group-text bg-white">
                            <i class="fas fa-search text-muted"></i>
                        </span>
                        <input type="text" class="form-control" placeholder="Buscar por placa, marca o cliente..."
                            data-table-filter="vehicles-table">
                    </div>
                </div>

                <!-- Botón -->
                <div class="col-md-4 text-end">
                    <a href="{{ route('vehicles.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-1"></i> Nuevo Vehículo
                    </a>
                </div>

            </div>



            <div class="card-body table-responsive p-0">
                <table id="vehicles-table" class="table table-hover text-nowrap">
=======
                <h3 class="card-title">Lista Vehiculos</h3>

                <div class="card-tools">
                    <a href="{{ route('vehicles.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Nuevo Vehiculo
                    </a>
                </div>
            </div>

            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
>>>>>>> 964613b02c73302aea2dc33386313b314db28634
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Vehiculo</th>
                            <th>Placa</th>
                            <th>Dueño</th>
                            <th>Año</th>
                            <th>Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($vehicles as $vehicle)
                            <tr>
                                <td>{{ $vehicle->id }}</td>
                                <td>{{ $vehicle->brand }} {{ $vehicle->model }}</td>
                                <td>{{ $vehicle->plate }}</td>
                                <td>{{ $vehicle->client->fullName() }}</td>
                                <td>{{ $vehicle->year ?? '—' }}</td>
                                <td>
                                    <a href="{{ route('vehicles.show', $vehicle) }}" class="btn btn-info btn-sm">
                                        <i class="fas fa-eye"></i>
                                    </a>

                                    <a href="{{ route('vehicles.edit', $vehicle) }}" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <form action="{{ route('vehicles.destroy', $vehicle) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')

                                        <button type="button" class="btn btn-danger btn-sm" data-confirm
                                            data-title="¿Eliminar vehículo?"
                                            data-text="Se perderá el historial del vehículo" data-confirm="Sí, eliminar">
                                            <i class="fas fa-trash"></i>
                                        </button>

                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">
                                    No se encontraron
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="card-footer clearfix">
                {{ $vehicles->links() }}
            </div>
        </div>

    </div>
@endsection
