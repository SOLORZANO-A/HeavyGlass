@extends('layouts.app')

@section('title', 'New Work Order')

@section('content')
    <div class="container-fluid">

        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Creación Orden de Trabajo</h3>
            </div>

            <form action="{{ route('work_orders.store') }}" method="POST">
                @csrf

                <div class="card-body">

                    {{-- Intake Sheet --}}
                    <div class="form-group">
                        <label>Vehiculo / Hoja de ingreso</label>
                        <select name="intake_sheet_id" id="intake_sheet_id" class="form-control select2" required>

                            <option value="">Seleccione la hoja de ingreso</option>

                            @foreach ($intakeSheets as $sheet)
                                <option value="{{ $sheet->id }}">
                                    #{{ $sheet->id }}
                                    | {{ $sheet->vehicle->plate }}
                                    | {{ $sheet->vehicle->brand }} {{ $sheet->vehicle->model }}
                                    | {{ $sheet->created_at->format('Y-m-d') }}
                                </option>
                            @endforeach
                        </select>

                    </div>

                    {{-- Work Type --}}
                    <div class="form-group">
                        <label>Tipo de Trabajo</label>
                        <select name="work_type_ids[]" class="form-control" multiple required>
                            @foreach ($workTypes as $type)
                                <option value="{{ $type->id }}">
                                    {{ $type->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>


                    {{-- Technician --}}
                    <div class="form-group">
                        <label>Técnicos asignados</label>

                        <select name="technicians[]" class="form-control select2" multiple required>

                            @foreach ($technicians as $tech)
                                <option value="{{ $tech->id }}">
                                    {{ $tech->fullName() }}
                                    @if ($tech->specialization)
                                        ({{ $tech->specialization }})
                                    @endif
                                </option>
                            @endforeach

                        </select>
                    </div>




                    <div class="form-group">
                        <label>Fecha de inicio</label>
                        <input type="date" name="started_at" class="form-control" value="{{ old('started_at') }}">
                    </div>



                    {{-- Status --}}
                    <div class="form-group">
                        <label>Estado</label>
                        <select name="status" class="form-control" required>
                            <option value="pending">Pendiente</option>
                            <option value="in_progress">En proceso</option>
                            <option value="paused">Pausado</option>
                            <option value="completed">Completo</option>
                        </select>
                    </div>

                    {{-- Description --}}
                    <div class="form-group">
                        <label>Descripción</label>
                        <textarea name="description" class="form-control" rows="3"></textarea>
                    </div>

                </div>

                <div class="card-footer">
                    <a href="{{ route('work_orders.index') }}" class="btn btn-secondary">
                        Cancelar
                    </a>
                    <button class="btn btn-primary">Guardar orden de trabajo</button>
                </div>
            </form>

        </div>

    </div>
@endsection
@push('scripts')
    <script>
        $('#intake_sheet_id').select2({
            placeholder: 'Buscar por placa, ID o fecha',
            allowClear: true,
            width: '100%',
            minimumResultsForSearch: 0,
            matcher: function(params, data) {

                if ($.trim(params.term) === '') {
                    return data;
                }

                if (typeof data.text === 'undefined') {
                    return null;
                }

                if (data.text.toLowerCase().includes(params.term.toLowerCase())) {
                    return data;
                }

                return null;
            }
        });
    </script>
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                placeholder: 'Seleccione uno o más técnicos',
                width: '100%'
            });
        });
    </script>
@endpush
@push('styles')
    <style>
        /* Select2 altura igual a inputs */
        .select2-container .select2-selection--single {
            height: 38px;
            padding: 4px 8px;
            border: 1px solid #ced4da;
            border-radius: .25rem;
        }

        .select2-selection__rendered {
            line-height: 28px !important;
        }

        .select2-selection__arrow {
            height: 36px;
        }

        /* Mejor dropdown */
        .select2-dropdown {
            border-radius: .25rem;
        }
    </style>
@endpush
