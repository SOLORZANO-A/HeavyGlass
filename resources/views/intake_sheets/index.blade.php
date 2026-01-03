@extends('layouts.app')

@section('title', 'Intake Sheets')

@section('content')
    <div class="container-fluid">
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                {{ session('error') }}
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
        @endif


        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Vehículos – Hojas de Ingreso</h3>

                <div class="card-tools">
                    <a href="{{ route('intake_sheets.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Nueva Hoja de Ingreso
                    </a>
                </div>
            </div>

            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Cliente</th>
                            <th>Vehículo</th>
                            <th>Placa</th>
                            <th>Ingreso</th>
                            <th>Combustible</th>
                            <th>KM</th>
                            <th>Condición</th>
                            <th>Fotos</th>
                            <th>Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($intakeSheets as $sheet)
                            <tr>
                                <td>{{ $sheet->id }}</td>

                                {{-- CLIENTE --}}
                                <td>
                                    {{ $sheet->vehicle?->client?->fullName() ?? '—' }}
                                </td>

                                {{-- VEHÍCULO --}}
                                <td>
                                    {{ $sheet->vehicle?->brand ?? '' }}
                                    {{ $sheet->vehicle?->model ?? '' }}
                                </td>

                                {{-- PLACA --}}
                                <td>{{ $sheet->vehicle?->plate ?? '—' }}</td>

                                {{-- FECHA INGRESO --}}
                                <td>
                                    {{ $sheet->entry_at ? $sheet->entry_at->format('Y-m-d H:i') : '—' }}
                                </td>

                                {{-- COMBUSTIBLE --}}
                                <td>{{ $sheet->fuel_level ?? '—' }}</td>

                                {{-- KM --}}
                                <td>{{ $sheet->km_at_entry ?? '—' }}</td>

                                {{-- CONDICIONES --}}
                                <td>
                                    @if ($sheet->has_dents)
                                        <span class="badge badge-warning">Aboll.</span>
                                    @endif
                                    @if ($sheet->has_scratches)
                                        <span class="badge badge-info">Ray.</span>
                                    @endif
                                    @if ($sheet->has_cracks)
                                        <span class="badge badge-danger">Grietas</span>
                                    @endif
                                    @if (!$sheet->has_dents && !$sheet->has_scratches && !$sheet->has_cracks)
                                        <span class="text-muted">OK</span>
                                    @endif
                                </td>

                                {{-- FOTOS --}}
                                <td class="text-center">
                                    @if ($sheet->photos && $sheet->photos->count())
                                        <span class="badge badge-success">
                                            {{ $sheet->photos->count() }} 📷
                                        </span>
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>

                                {{-- OPCIONES --}}
                                <td>
                                    <a href="{{ route('intake_sheets.show', $sheet) }}" class="btn btn-info btn-sm">
                                        <i class="fas fa-eye"></i>
                                    </a>

                                    <a href="{{ route('intake_sheets.edit', $sheet) }}" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <form action="{{ route('intake_sheets.destroy', $sheet) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')

                                        <button type="button" class="btn btn-danger btn-sm" data-confirm
                                            data-title="¿Eliminar hoja de ingreso?" data-text="La hoja de ingresoserá eliminado definitivamente"
                                            data-confirm="Sí, eliminar">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="text-center text-muted">
                                    No se encontraron hojas de ingreso
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="card-footer clearfix">
                {{ $intakeSheets->links() }}
            </div>
        </div>

    </div>
@endsection
