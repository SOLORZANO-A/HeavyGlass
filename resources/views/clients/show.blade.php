@extends('layouts.app')

@section('title', 'Client Details')

@section('content')
<<<<<<< HEAD

@php
    $staffTypeLabels = [
        'third'        => 'Tercera Persona',
        'insurance'           => 'Aseguradora',
        'owner'           => 'Dueño',
    ];
@endphp
=======
>>>>>>> 964613b02c73302aea2dc33386313b314db28634
    <div class="container-fluid">

        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">Información Cliente</h3>

                <div class="card-tools">
                    <a href="{{ route('clients.edit', $client) }}" class="btn btn-warning btn-sm">
                        <i class="fas fa-edit"></i> Editar
                    </a>

                    <a href="{{ route('clients.index') }}" class="btn btn-secondary btn-sm">
                        Atras
                    </a>
                </div>
            </div>

            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th width="200">Nombre Completo</th>
                        <td>{{ $client->fullName() }}</td>
                    </tr>
                    <tr>
                        <th>Documento</th>
                        <td>{{ $client->document }}</td>
                    </tr>
                    <tr>
                        <th>Copia de cédula</th>
                        <td>
                            @if ($client->id_copy_path)
                                <a href="{{ asset('storage/' . $client->id_copy_path) }}" target="_blank"
                                    class="btn btn-sm btn-info">
                                    Ver copia de cédula
                                </a>
                            @else
                                —
                            @endif
                        </td>
                    </tr>


                    <tr>
                        <th>Telefono</th>
                        <td>{{ $client->phone ?? '—' }}</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>{{ $client->email ?? '—' }}</td>
                    </tr>
                    <tr>
                        <th>Dirreción</th>
                        <td>{{ $client->address ?? '—' }}</td>
                    </tr>
                    <tr>
<<<<<<< HEAD
                        <th>Numero de referencia</th>
                        <td>{{ $client->reference_number ?? '—' }}</td>
                    </tr>
                    <tr>
                        
                        <th>Tipo Cliente</th>
                        <td>{{ $staffTypeLabels[$client->client_type] ?? ucfirst($client->client_type) }}</td>
=======
                        <th>Tipo Cliente</th>
                        <td>{{ ucfirst($client->client_type) }}</td>
>>>>>>> 964613b02c73302aea2dc33386313b314db28634
                    </tr>
                    <tr>
                        <th>Descripcion</th>
                        <td>{{ $client->description ?? '—' }}</td>
                    </tr>
                    <tr>
                        <th>Hora de creacion</th>
                        <td>{{ $client->created_at->format('Y-m-d H:i') }}</td>
                    </tr>
                </table>
            </div>

            <div class="card-footer">
                <a href="{{ route('clients.index') }}" class="btn btn-secondary">
                    Regresar a la lista
                </a>
            </div>
        </div>

    </div>
@endsection
