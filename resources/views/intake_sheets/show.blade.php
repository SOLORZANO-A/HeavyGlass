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
                <a href="{{ route('intake_sheets.edit', $intakeSheet) }}"
                   class="btn btn-warning btn-sm">
                    <i class="fas fa-edit"></i> Editar
                </a>

                <a href="{{ route('intake_sheets.index') }}"
                   class="btn btn-secondary btn-sm">
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
                        {{ $intakeSheet->entry_at
                            ? $intakeSheet->entry_at->format('Y-m-d H:i')
                            : '—' }}
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

                        @if (
                            !$intakeSheet->has_dents &&
                            !$intakeSheet->has_scratches &&
                            !$intakeSheet->has_cracks
                        )
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
                                        <a href="{{ asset('storage/' . $photo->path) }}"
                                           target="_blank">
                                            <img src="{{ asset('storage/' . $photo->path) }}"
                                                 class="img-fluid img-thumbnail"
                                                 alt="Foto vehículo">
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

        </div>

        <div class="card-footer">
            <a href="{{ route('intake_sheets.index') }}" class="btn btn-secondary">
                Volver al listado
            </a>
        </div>
    </div>

</div>
@endsection
