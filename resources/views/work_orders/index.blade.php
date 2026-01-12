@extends('layouts.app')

@section('title', 'Work Orders')

@section('content')
    <div class="container-fluid">

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-tools"></i> Órdenes de Taller
                </h3>
            </div>

            <div class="row mb-3 align-items-center">

                <!-- Buscador -->
                <div class="col-md-8">
                    <div class="input-group">
                        <span class="input-group-text bg-white">
                            <i class="fas fa-search text-muted"></i>
                        </span>
                        <input type="text" class="form-control" placeholder="Buscar por orden, vehículo o técnico..."
                            data-table-filter="workorders-table">
                    </div>
                </div>

                <!-- Botón -->
                <div class="col-md-4 text-end">
                    <a href="{{ route('work_orders.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-1"></i> Nueva Orden de Trabajo
                    </a>
                </div>

            </div>


            <div class="card-body table-responsive p-0">
                <table id="workorders-table" class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Vehículo</th>
                            <th>Tipo de trabajo</th>
                            <th>Técnicos</th>
                            <th>Estado</th>
                            <th>Fecha asignación</th>
                            <th>Fecha inicio</th>
                            <th>Fecha finalización</th>
                            <th>Opciones</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($workOrders as $order)
                            <tr>
                                {{-- ID --}}
                                <td>#{{ $order->id }}</td>

                                {{-- VEHÍCULO --}}
                                <td>
                                    {{ $order->intakeSheet->vehicle->brand }}
                                    {{ $order->intakeSheet->vehicle->model }}
                                    <br>
                                    <small class="text-muted">
                                        {{ $order->intakeSheet->vehicle->plate }}
                                    </small>
                                </td>

                                {{-- TIPOS DE TRABAJO --}}
                                <td class="align-top">
                                    <ul class="list-unstyled mb-0">
                                        @foreach ($order->workTypes as $type)
                                            <li>
                                                <span class="badge badge-secondary">
                                                    {{ $type->name }}
                                                </span>
                                            </li>
                                        @endforeach
                                    </ul>
                                </td>


                                {{-- TÉCNICOS --}}
                                <td class="align-top">
                                    @forelse ($order->technicians as $technician)
                                        <div class="mb-1">
                                            <span class="badge badge-info d-block text-left">
                                                {{ $technician->fullName() }}
                                                @if ($technician->specialization)
                                                    <small class="text-light">
                                                        ({{ $technician->specialization }})
                                                    </small>
                                                @endif
                                            </span>
                                        </div>
                                    @empty
                                        <span class="text-muted">Sin técnico asignado</span>
                                    @endforelse
                                </td>


                                {{-- ESTADO --}}
                                @php
                                    $statusColors = [
                                        'pending' => 'secondary',
                                        'in_progress' => 'warning',
                                        'paused' => 'info',
                                        'completed' => 'success',
                                    ];
                                @endphp
                                <td>
                                    <span class="badge badge-{{ $statusColors[$order->status] ?? 'secondary' }}">
                                        {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                                    </span>
                                </td>

                                {{-- FECHAS --}}
                                <td>{{ $order->assigned_at?->format('Y-m-d') ?? '—' }}</td>
                                <td>{{ $order->started_at?->format('Y-m-d') ?? '—' }}</td>
                                <td>{{ $order->finished_at?->format('Y-m-d') ?? '—' }}</td>

                                {{-- OPCIONES --}}
                                <td>
                                    <a href="{{ route('work_orders.show', $order) }}" class="btn btn-info btn-sm">
                                        <i class="fas fa-eye"></i>
                                    </a>

                                    <a href="{{ route('work_orders.edit', $order) }}" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    @role('admin')
                                        <form action="{{ route('work_orders.destroy', $order) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')

                                            <button type="button" class="btn btn-danger btn-sm" data-confirm
                                                data-title="¿Eliminar orden de trabajo?"
                                                data-text="La orden de trabajo será eliminada definitivamente"
                                                data-confirm="Sí, eliminar">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    @endrole

                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center text-muted">
                                    No hay órdenes de trabajo
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="card-footer clearfix">
                {{ $workOrders->links() }}
            </div>
        </div>

    </div>
@endsection
