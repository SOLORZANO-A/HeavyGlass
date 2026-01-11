@extends('layouts.app')

@section('title', 'Proformas')

@section('content')
    <div class="container-fluid">

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-file-invoice"></i> Proformas
                </h3>
            </div>

            <div class="row mb-3 align-items-center">

                <!-- Buscador -->
                <div class="col-md-8">
                    <div class="input-group">
                        <span class="input-group-text bg-white">
                            <i class="fas fa-search text-muted"></i>
                        </span>
                        <input type="text" class="form-control" placeholder="Buscar por número, cliente o vehículo..."
                            data-table-filter="proformas-table">
                    </div>
                </div>

                <!-- Botón -->
                <div class="col-md-4 text-end">
                    <a href="{{ route('proformas.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-1"></i> Nueva Proforma
                    </a>
                </div>

            </div>


            <div class="card-body table-responsive p-0">
                <table id="proformas-table" class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Cliente</th>
                            <th>Vehiculo</th>
                            <th>Total</th>
                            <th>Firma</th>
                            <th>Estado</th>
                            <th>Fecha</th>
                            <th width="180">Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($proformas as $proforma)
                            <tr>
                                <td>{{ $proforma->id }}</td>

                                <td>{{ $proforma->client_name }}</td>

                                <td>
                                    {{ $proforma->vehicle_brand }} {{ $proforma->vehicle_model }}
                                    <br>
                                    <small class="text-muted">{{ $proforma->vehicle_plate }}</small>
                                </td>

                                <td>
                                    ${{ number_format($proforma->total, 2) }}
                                </td>
                                <td>
                                    @if ($proforma->isSigned())
                                        <span class="badge badge-success">
                                            <i class="fas fa-pen"></i> Firmada
                                        </span>
                                        <br>
                                        <small class="text-muted">
                                            {{ $proforma->signed_at?->format('Y-m-d') }}
                                        </small>
                                    @else
                                        <span class="badge badge-secondary">
                                            <i class="fas fa-pen-slash"></i> No firmada
                                        </span>
                                    @endif
                                </td>



                                {{-- STATUS BADGE --}}
                                <td>
                                    @php
                                        $statusColors = [
                                            'pending' => 'warning',
                                            'partial' => 'info',
                                            'paid' => 'success',
                                            'approved' => 'success',
                                            'cancelled' => 'danger',
                                        ];
                                    @endphp

                                    <span class="badge badge-{{ $statusColors[$proforma->status] ?? 'secondary' }}">
                                        {{ ucfirst($proforma->status) }}
                                    </span>
                                </td>

                                <td>{{ $proforma->created_at->format('Y-m-d') }}</td>

                                <td>
                                    {{-- VIEW --}}
                                    <a href="{{ route('proformas.show', $proforma) }}" class="btn btn-info btn-sm">
                                        <i class="fas fa-eye"></i>
                                    </a>

                                    {{-- EDIT (solo si no está pagada) --}}
                                    @if ($proforma->status !== 'paid')
                                        <a href="{{ route('proformas.edit', $proforma) }}" class="btn btn-warning btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    @endif

                                    {{-- REGISTER PAYMENT (solo si no está pagada) --}}
                                    @if ($proforma->status !== 'paid')
                                        <a href="{{ route('payments.create', ['proforma_id' => $proforma->id]) }}"
                                            class="btn btn-success btn-sm">
                                            <i class="fas fa-cash-register"></i>
                                        </a>
                                    @endif
                                    @role('admin')
                                        <form action="{{ route('proformas.destroy', $proforma) }}" method="POST">
                                            @csrf
                                            @method('DELETE')

                                            <button type="button" class="btn btn-danger btn-sm" data-confirm
                                                data-title="¿Eliminar proforma?" data-text="No se puede recuperar después"
                                                data-confirm="Eliminar">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    @endrole
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted">
                                    No hay proformas
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="card-footer clearfix">
                {{ $proformas->links() }}
            </div>
        </div>

    </div>
@endsection
