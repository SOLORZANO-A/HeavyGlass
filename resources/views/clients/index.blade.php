@extends('layouts.app')

@section('title', 'Clients')

@section('content')
    <div class="container-fluid">

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-users"></i> Lista de Clientes
                </h3>
            </div>

            <div class="row mb-3 align-items-center">
                <div class="col-md-8">
                    <div class="input-group">
                        <span class="input-group-text bg-light">
                            <i class="fas fa-search text-muted"></i>
                        </span>
                        <input type="text" class="form-control"
                            placeholder="Buscar cliente por nombre, cédula o teléfono..." data-table-filter="clients-table">
                    </div>
                </div>

                <div class="col-md-4 text-end">
                    <a href="{{ route('clients.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Nuevo Cliente
                    </a>
                </div>
            </div>


            <div class="card-body table-responsive p-0">
                <table id="clients-table" class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre Completo</th>
                            <th>Cedula</th>
                            <th>Telefono</th>
                            <th>Tipo</th>
                            <th>Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($clients as $client)
                            <tr>
                                <td>{{ $client->id }}</td>
                                <td>{{ $client->fullName() }}</td>
                                <td>{{ $client->document }}</td>
                                <td>{{ $client->phone ?? '—' }}</td>
                                <td>
                                    @switch($client->client_type)
                                        @case('owner')
                                            Dueño
                                        @break

                                        @case('third')
                                            Tercera persona
                                        @break
                                        @case('insurance')
                                            Aseguradora
                                        @break
                                        @default
                                            —
                                    @endswitch
                                </td>

                                <td>
                                    <a href="{{ route('clients.show', $client) }}" class="btn btn-info btn-sm">
                                        <i class="fas fa-eye"></i>
                                    </a>

                                    <a href="{{ route('clients.edit', $client) }}" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <form action="{{ route('clients.destroy', $client) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')

                                        <button type="button" class="btn btn-danger btn-sm" data-confirm
                                            data-title="¿Eliminar cliente?"
                                            data-text="El cliente será eliminado definitivamente"
                                            data-confirm="Sí, eliminar">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>


                                </td>
                            </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted">
                                        No se encontraron CLientes
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="card-footer clearfix">
                    {{ $clients->links() }}
                </div>
            </div>

        </div>
    @endsection
