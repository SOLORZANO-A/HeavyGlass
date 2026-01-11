@extends('layouts.app')

@section('title', 'Work Order Details')

@section('content')
    <div class="container-fluid">

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Orden de Trabajo #{{ $workOrder->id }}</h3>
            </div>

            <div class="card-body">
                <div class="row">

                    {{-- LEFT COLUMN --}}
                    <div class="col-md-6">

                        <h5><strong>Vehiculo</strong></h5>
                        <p>
                            {{ $workOrder->intakeSheet->vehicle->brand }}
                            {{ $workOrder->intakeSheet->vehicle->model }}
                            <br>
                            <small class="text-muted">
                                {{ $workOrder->intakeSheet->vehicle->plate }}
                            </small>
                        </p>

                        <hr>

                        <h5><strong>Tipo de trabajo</strong></h5>
                        <ul>
                            @foreach ($workOrder->workTypes as $type)
                                <li>{{ $type->name }}</li>
                            @endforeach
                        </ul>

                        <hr>

                        <h5><strong>Técnicos asignados</strong></h5>

                        @if ($workOrder->technicians->count())
                            <ul class="list-unstyled">
                                @foreach ($workOrder->technicians as $technician)
                                    <li>
                                        <span class="badge badge-info">
                                            {{ $technician->first_name }} {{ $technician->last_name }}
                                            @if ($technician->specialization)
                                                ({{ $technician->specialization }})
                                            @endif
                                        </span>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-muted">Sin técnicos asignados</p>
                        @endif


                    </div>

                    {{-- RIGHT COLUMN --}}
                    <div class="col-md-6">

                        <div class="col-md-6">
                            <h5><strong>Estado</strong></h5>

                            @php
                                $statusLabels = [
                                    'pending' => 'Pendiente',
                                    'in_progress' => 'En progreso',
                                    'paused' => 'Pausado',
                                    'completed' => 'Completado',
                                ];

                                $statusColors = [
                                    'pending' => 'secondary',
                                    'in_progress' => 'primary',
                                    'paused' => 'warning',
                                    'completed' => 'success',
                                ];
                            @endphp

                            <span class="badge badge-{{ $statusColors[$workOrder->status] ?? 'secondary' }}">
                                {{ $statusLabels[$workOrder->status] ?? '—' }}
                            </span>
                        </div>


                        <hr>

                        <h5><strong>Fecha de asignación</strong></h5>
                        <p>{{ $workOrder->assigned_at?->format('Y-m-d H:i') ?? '—' }}</p>

                        <h5><strong>Fecha de inicio </strong></h5>
                        <p>{{ $workOrder->started_at?->format('Y-m-d H:i') ?? '—' }}</p>

                        <h5><strong>Fecha de Finalizacion</strong></h5>
                        <p>{{ $workOrder->finished_at?->format('Y-m-d H:i') ?? '—' }}</p>

                        <hr>

                        <h5><strong>Descripcion</strong></h5>
                        <p>{{ $workOrder->description ?? '—' }}</p>

                    </div>

                </div>
            </div>

            <div class="card-footer">
                <a href="{{ route('work_orders.index') }}" class="btn btn-secondary">
                    Atras
                </a>

                <a href="{{ route('work_orders.edit', $workOrder) }}" class="btn btn-warning">
                    Editar
                </a>
            </div>
        </div>

    </div>
@endsection
