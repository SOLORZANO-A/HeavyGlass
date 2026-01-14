@extends('layouts.app')

@section('title', 'Intake Sheet Details')

@section('content')
    <div class="container-fluid">

        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">
                    Hoja de Ingreso #{{ $intakeSheet->id }}
                </h3>

                <div class="card-tools">
                    <a href="{{ route('intake_sheets.edit', $intakeSheet) }}" class="btn btn-warning btn-sm">
                        <i class="fas fa-edit"></i> Editar
                    </a>

                    <a href="{{ route('intake_sheets.index') }}" class="btn btn-secondary btn-sm">
                        Volver
                    </a>
                </div>
            </div>

            <div class="card-body">

                <table class="table table-bordered">

                    {{-- VEHÍCULO --}}
                    <tr>
                        <th width="250">Vehículo</th>
                        <td>
                            {{ $intakeSheet->vehicle?->plate ?? '—' }} —
                            {{ $intakeSheet->vehicle?->brand ?? '' }}
                            {{ $intakeSheet->vehicle?->model ?? '' }}
                        </td>
                    </tr>

                    {{-- CLIENTE --}}
                    <tr>
                        <th>Cliente</th>
                        <td>
                            {{ $intakeSheet->vehicle?->client?->fullName() ?? '—' }}
                        </td>
                    </tr>

                    {{-- FECHA INGRESO --}}
                    <tr>
                        <th>Fecha de Ingreso</th>
                        <td>
                            {{ $intakeSheet->entry_at ? $intakeSheet->entry_at->format('Y-m-d H:i') : '—' }}
                        </td>
                    </tr>

                    {{-- KM --}}
                    <tr>
                        <th>Kilometraje</th>
                        <td>{{ $intakeSheet->km_at_entry ?? '—' }}</td>
                    </tr>

                    {{-- COMBUSTIBLE --}}
                    <tr>
                        <th>Nivel de Combustible</th>
                        <td>{{ ucfirst($intakeSheet->fuel_level ?? '—') }}</td>
                    </tr>

                    {{-- CONDICIÓN --}}
                    <tr>
                        <th>Condición del Vehículo</th>
                        <td>
                            @if ($intakeSheet->has_dents)
                                <span class="badge badge-warning">Abolladuras</span>
                            @endif

                            @if ($intakeSheet->has_scratches)
                                <span class="badge badge-info">Arañazos</span>
                            @endif

                            @if ($intakeSheet->has_cracks)
                                <span class="badge badge-danger">Grietas</span>
                            @endif

                            @if (!$intakeSheet->has_dents && !$intakeSheet->has_scratches && !$intakeSheet->has_cracks)
                                <span class="text-muted">Sin daños visibles</span>
                            @endif
                        </td>
                    </tr>

                    {{-- OBJETOS DE VALOR --}}
                    <tr>
                        <th>Objetos de Valor</th>
                        <td>{{ $intakeSheet->valuables ?? '—' }}</td>
                    </tr>

                    {{-- OBSERVACIONES --}}
                    <tr>
                        <th>Observaciones</th>
                        <td>{{ $intakeSheet->observations ?? '—' }}</td>
                    </tr>

                    {{-- FOTOS --}}
                    <tr>
                        <th>Fotos del Vehículo</th>
                        <td>
                            @if ($intakeSheet->photos && $intakeSheet->photos->count())
                                <div class="row">
                                    @foreach ($intakeSheet->photos as $photo)
                                        <div class="col-md-3 mb-3">
                                            <a href="{{ asset('storage/' . $photo->path) }}" target="_blank">
                                                <img src="{{ asset('storage/' . $photo->path) }}"
                                                    class="img-fluid img-thumbnail" alt="Foto vehículo">
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <span class="text-muted">No hay fotos registradas</span>
                            @endif
                        </td>
                    </tr>

                </table>
                {{-- ================= INSPECCIÓN VEHICULAR ================= --}}
                @if ($intakeSheet->inspection)

                    <hr>
                    <h4 class="mt-4 mb-3">
                        <i class="fas fa-search"></i> Inspección Vehicular
                    </h4>

                    <p class="text-muted">
                        Registrada el
                        {{ $intakeSheet->inspection->created_at->format('d/m/Y H:i') }}
                        por {{ $intakeSheet->inspection->createdBy?->name ?? 'Sistema' }}
                    </p>

                    @foreach ($intakeSheet->inspection->items->groupBy('inspection_zone_id') as $zoneItems)
                        @php
                            $zone = $zoneItems->first()->zone;
                        @endphp

                        <div class="card mb-3">
                            <div class="card-header bg-light">
                                <strong>{{ $zone->name }}</strong>
                            </div>

                            <div class="card-body p-0">
                                <table class="table table-bordered mb-0">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Pieza</th>
                                            <th class="text-center">Cambio</th>
                                            <th class="text-center">Pintura</th>
                                            <th class="text-center">Fibra</th>
                                            <th class="text-center">Enderezado</th>
                                            <th class="text-center">Fisura</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($zoneItems as $item)
                                            <tr>
                                                <td>{{ $item->part->name }}</td>
                                                <td class="text-center">
                                                    @if ($item->change)
                                                        <span class="badge badge-success">✔</span>
                                                    @else
                                                        <span class="text-muted">—</span>
                                                    @endif
                                                </td>

                                                <td class="text-center">
                                                    @if ($item->paint)
                                                        <span class="badge badge-success">✔</span>
                                                    @else
                                                        <span class="text-muted">—</span>
                                                    @endif
                                                </td>

                                                <td class="text-center">
                                                    @if ($item->fiber)
                                                        <span class="badge badge-success">✔</span>
                                                    @else
                                                        <span class="text-muted">—</span>
                                                    @endif
                                                </td>

                                                <td class="text-center">
                                                    @if ($item->dent)
                                                        <span class="badge badge-success">✔</span>
                                                    @else
                                                        <span class="text-muted">—</span>
                                                    @endif
                                                </td>

                                                <td class="text-center">
                                                    @if ($item->crack)
                                                        <span class="badge badge-success">✔</span>
                                                    @else
                                                        <span class="text-muted">—</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            {{-- OBSERVACIONES POR ZONA --}}
                            @php
                                $zoneObservation = $intakeSheet->inspection?->observations[$zone->id] ?? null;
                            @endphp

                            @if ($zoneObservation)
                                <div class="card-footer">
                                    <strong>Observaciones:</strong>
                                    <p class="mb-0">{{ $zoneObservation }}</p>
                                </div>
                            @endif



                            {{-- FOTOS POR ZONA --}}
                            @php
                                $photos = $intakeSheet->inspection->photos->where('inspection_zone_id', $zone->id);
                            @endphp

                            @if ($photos->count())
                                <div class="card-footer">
                                    <strong>Fotos de {{ $zone->name }}</strong>
                                    <div class="row mt-2">
                                        @foreach ($photos as $photo)
                                            <div class="col-md-2 col-4 mb-2">
                                                <a href="{{ asset('storage/' . $photo->path) }}" target="_blank">
                                                    <img src="{{ asset('storage/' . $photo->path) }}"
                                                        class="img-fluid rounded border">
                                                </a>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif



                        </div>
                    @endforeach
                @else
                    <div class="alert alert-warning mt-4">
                        <i class="fas fa-exclamation-triangle"></i>
                        Esta hoja de ingreso aún no tiene una inspección vehicular registrada.
                    </div>
                @endif



            </div>

            <div class="card-footer">
                <a href="{{ route('intake_sheets.index') }}" class="btn btn-secondary">
                    Volver al listado
                </a>
            </div>
        </div>

    </div>
@endsection
