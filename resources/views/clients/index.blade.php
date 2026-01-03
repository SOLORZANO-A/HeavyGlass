@extends('layouts.app')

@section('title', 'Clients')

@section('content')
    <div class="container-fluid">

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Lista Clientes</h3>

                <div class="card-tools">
                    <a href="{{ route('clients.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Nuevo CLiente
                    </a>
                </div>
            </div>

            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
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
