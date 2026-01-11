@extends('layouts.app')

@section('title', 'Edit Proforma')

@section('content')
<div class="container-fluid">

    <div class="card card-warning">
        <div class="card-header">
            <h3 class="card-title">Editar Proforma #{{ $proforma->id }}</h3>
        </div>

        <form action="{{ route('proformas.update', $proforma) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="card-body">

                {{-- WORK ORDER --}}
                <div class="form-group">
                    <label>Orden de trabajo</label>
                    <input type="text"
                           class="form-control"
                           readonly
                           value="
                           @if ($proforma->workOrder)
                               #{{ $proforma->workOrder->id }} - {{ $proforma->workOrder->intakeSheet->vehicle->plate }}
                           @else
                               No work order assigned
                           @endif
                           ">
                </div>

                {{-- DETAILS --}}
                <h5>Proforma Detalles</h5>

                <div id="details-wrapper">
                    @foreach ($proforma->details as $i => $detail)
                        <div class="row mb-2">
                            <div class="col-md-6">
                                <input type="text"
                                       name="details[{{ $i }}][description]"
                                       class="form-control"
                                       value="{{ $detail->item_description }}">
                            </div>

                            <div class="col-md-3">
                                <input type="number"
                                       step="0.01"
                                       name="details[{{ $i }}][price]"
                                       class="form-control"
                                       value="{{ $detail->unit_price }}">
                            </div>

                            <div class="col-md-3">
                                <input type="number"
                                       name="details[{{ $i }}][quantity]"
                                       class="form-control"
                                       value="{{ $detail->quantity }}">
                            </div>
                        </div>
                    @endforeach
                </div>

                <button type="button"
                        class="btn btn-sm btn-secondary mb-3"
                        onclick="addDetailRow()">
                    <i class="fas fa-plus"></i> Agregar Items
                </button>

                {{-- OBSERVATIONS --}}
                <div class="form-group">
                    <label>Observaciones</label>
                    <textarea name="observations"
                              class="form-control"
                              rows="3">{{ old('observations', $proforma->observations) }}</textarea>
                </div>

            </div>

            <div class="card-footer">
                <a href="{{ route('proformas.show', $proforma) }}" class="btn btn-secondary">
                    Cancelar
                </a>

                <button type="submit" class="btn btn-warning">
                    Actualizar Proforma
                </button>
            </div>

        </form>
    </div>

</div>

<script>
    let detailIndex = {{ $proforma->details->count() }};

    function addDetailRow() {
        const wrapper = document.getElementById('details-wrapper');

        const row = document.createElement('div');
        row.classList.add('row', 'mb-2');

        row.innerHTML = `
            <div class="col-md-6">
                <input type="text"
                       name="details[${detailIndex}][description]"
                       class="form-control"
                       placeholder="Description">
            </div>
            <div class="col-md-3">
                <input type="number"
                       step="0.01"
                       name="details[${detailIndex}][price]"
                       class="form-control"
                       placeholder="Unit Price">
            </div>
            <div class="col-md-3">
                <input type="number"
                       name="details[${detailIndex}][quantity]"
                       class="form-control"
                       placeholder="Qty"
                       value="1">
            </div>
        `;

        wrapper.appendChild(row);
        detailIndex++;
    }
</script>
@endsection
