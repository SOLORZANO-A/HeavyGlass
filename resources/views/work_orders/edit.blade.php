@extends('layouts.app')

@section('title', 'Edit Work Order')

@section('content')
    <div class="container-fluid">

        <div class="card card-warning">
            <div class="card-header">
                <h3 class="card-title">Editar Orden de TRabajo</h3>
            </div>

            <form action="{{ route('work_orders.update', $workOrder) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="card-body">

                    {{-- Intake Sheet --}}
                    <div class="form-group">
                        <label>Vehiculo / Hoja de Ingreso</label>
                        <select name="intake_sheet_id" class="form-control" required>
                            @foreach ($intakeSheets as $sheet)
                                <option value="{{ $sheet->id }}"
                                    {{ $sheet->id == old('intake_sheet_id', $workOrder->intake_sheet_id) ? 'selected' : '' }}>
                                    {{ $sheet->vehicle->brand }}
                                    {{ $sheet->vehicle->model }}
                                    - {{ $sheet->vehicle->plate }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Work Type (SINGLE) --}}
                    <div class="form-group">
                        <label>Tipo de Trabajo</label>
                        <select name="work_type_ids[]" class="form-control" multiple required>
                            @foreach ($workTypes as $type)
                                <option value="{{ $type->id }}"
                                    {{ in_array($type->id, old('work_type_ids', $workOrder->workTypes->pluck('id')->toArray())) ? 'selected' : '' }}>
                                    {{ $type->name }}
                                </option>
                            @endforeach
                        </select>

                    </div>

                    {{-- Técnicos --}}
                    <div class="form-group">
                        <label>Técnicos asignados</label>

                        <select name="technicians[]" class="form-control select2" multiple required>

                            @foreach ($technicians as $tech)
                                <option value="{{ $tech->id }}"
                                    {{ $workOrder->technicians->contains($tech->id) ? 'selected' : '' }}>
                                    {{ $tech->first_name }} {{ $tech->last_name }}
                                    @if ($tech->specialization)
                                        ({{ $tech->specialization }})
                                    @endif
                                </option>
                            @endforeach

                        </select>
                    </div>


                    {{-- Status --}}
                    <div class="form-group">
                        <label>Estado</label>
                        <select name="status" class="form-control" required>
                            @php
                                $statuses = [
                                    'pending' => 'Pendiente',
                                    'in_progress' => 'En progreso',
                                    'paused' => 'Pausado',
                                    'completed' => 'Completado',
                                ];
                            @endphp

                            @foreach ($statuses as $value => $label)
                                <option value="{{ $value }}"
                                    {{ $value == old('status', $workOrder->status) ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Fecha de inicio</label>
                        <input type="date" name="started_at"
                            class="form-control @error('started_at') is-invalid @enderror"
                            value="{{ old('started_at', optional($workOrder->started_at)->format('Y-m-d')) }}">

                        @error('started_at')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>



                    {{-- Description --}}
                    <div class="form-group">
                        <label>Descripcion</label>
                        <textarea name="description" class="form-control" rows="3">{{ old('description', $workOrder->description) }}</textarea>
                    </div>

                </div>

                <div class="card-footer">
                    <a href="{{ route('work_orders.index') }}" class="btn btn-secondary">Cancelar</a>
                    <button class="btn btn-warning">Actualizar Orden de Trabajo</button>
                </div>

            </form>

        </div>

    </div>
@endsection
@push('scripts')
<script>
    $(document).ready(function () {
        $('.select2').select2({
            placeholder: 'Seleccione uno o más técnicos',
            width: '100%'
        });
    });
</script>
@endpush

