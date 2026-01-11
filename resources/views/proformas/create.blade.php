@extends('layouts.app')

@section('title', 'New Proforma')

@section('content')
    <div class="container-fluid">

        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Crea la proforma</h3>
            </div>

            <form action="{{ route('proformas.store') }}" method="POST">
                @csrf

                <div class="card-body">

                    {{-- WORK ORDER --}}
                    <div class="form-group">
                        <label>Orden de trabajo</label>

                        <select name="work_order_id" class="form-control select2 @error('work_order_id') is-invalid @enderror"
                            required>

                            <option value="">-- Selecciona la Orden de Trabajo --</option>

                            @foreach ($workOrders as $order)
                                <option value="{{ $order->id }}">
                                    #{{ $order->id }}
                                    - {{ $order->intakeSheet->vehicle->plate }}
                                    | {{ $order->intakeSheet->vehicle->brand }}
                                    {{ $order->intakeSheet->vehicle->model }}
                                </option>
                            @endforeach

                        </select>

                        @error('work_order_id')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>


                    <hr>

                    <h5>Detalles Proforma</h5>

                    <div id="details-wrapper">
                        <div class="row mb-2">
                            <div class="col-md-6">
                                <input type="text" name="details[0][description]" class="form-control"
                                    placeholder="Descripción" required>
                            </div>
                            <div class="col-md-3">
                                <input type="number" step="0.01" name="details[0][price]" class="form-control"
                                    placeholder="Precio unitario" required>
                            </div>
                            <div class="col-md-3">
                                <input type="number" name="details[0][quantity]" class="form-control"
                                    placeholder="Cantidad" value="1" min="1" required>
                            </div>
                        </div>
                    </div>

                    <button type="button" class="btn btn-sm btn-secondary mb-3" onclick="addDetailRow()">
                        <i class="fas fa-plus"></i> Agregar Items
                    </button>

                    <div class="form-group">
                        <label>Observaciones</label>
                        <textarea name="observations" class="form-control" rows="3">{{ old('observations') }}</textarea>
                    </div>

                </div>

                <div class="card-footer">
                    <a href="{{ route('proformas.index') }}" class="btn btn-secondary">
                        Cancelar
                    </a>

                    <button type="submit" class="btn btn-primary">
                        Crear Proforma
                    </button>
                </div>

            </form>
        </div>

    </div>

    <script>
        let detailIndex = 1;

        function addDetailRow() {
            const wrapper = document.getElementById('details-wrapper');

            const row = document.createElement('div');
            row.classList.add('row', 'mb-2');

            row.innerHTML = `
        <div class="col-md-6">
            <input type="text"
                   name="details[${detailIndex}][description]"
                   class="form-control"
                   placeholder="Description"
                   required>
        </div>
        <div class="col-md-3">
            <input type="number"
                   step="0.01"
                   name="details[${detailIndex}][price]"
                   class="form-control"
                   placeholder="Price"
                   required>
        </div>
        <div class="col-md-3">
            <input type="number"
                   name="details[${detailIndex}][quantity]"
                   class="form-control"
                   placeholder="Qty"
                   value="1"
                   min="1"
                   required>
        </div>
    `;

            wrapper.appendChild(row);
            detailIndex++;
        }
    </script>
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                placeholder: 'Seleccione una orden de trabajo',
                allowClear: true,
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