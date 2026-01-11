@extends('layouts.app')

@section('title', 'Registrar Pago')

@section('content')
    <div class="container-fluid">

        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Registrar Pago</h3>
            </div>

            <form action="{{ route('payments.store') }}" method="POST">
                @csrf

                <div class="card-body">

                    {{-- ERRORES --}}
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- PROFORMA --}}
<<<<<<< HEAD
                    <select name="proforma_id" id="proforma_select"
                        class="form-control select2 @error('proforma_id') is-invalid @enderror" required>

                        <option value="">-- Seleccione Proforma --</option>

                        @foreach ($proformas as $proforma)
                            @php
                                $paid = $proforma->payments->where('status', 'valid')->sum('amount');
                                $balance = round($proforma->total - $paid, 2);
                                $isSigned = $proforma->signature_status === 'signed';
                            @endphp

                            <option value="{{ $proforma->id }}" data-total="{{ $proforma->total }}"
                                data-paid="{{ $paid }}" data-balance="{{ $balance }}"
                                {{ !$isSigned ? 'disabled' : '' }}>

                                #{{ $proforma->id }} — {{ $proforma->vehicle_plate }}
                                @if (!$isSigned)
                                    ❌ (No firmada)
                                @elseif($balance <= 0)
                                    ✅ (Pagada)
                                @else
                                    💰 (Saldo: ${{ number_format($balance, 2) }})
                                @endif
                            </option>
                        @endforeach
                    </select>

=======
                    <div class="form-group">
                        <label>Proforma</label>
                        <select name="proforma_id" id="proforma_select" class="form-control" required>

                            <option value="">-- Seleccione Proforma --</option>

                            @foreach ($proformas as $proforma)
                                @php
                                    $paid = $proforma->payments->where('status', 'valid')->sum('amount');

                                    $balance = round($proforma->total - $paid, 2);

                                    $isSigned = $proforma->signature_status === 'signed';
                                @endphp

                                <option value="{{ $proforma->id }}" data-total="{{ $proforma->total }}"
                                    data-paid="{{ $paid }}" data-balance="{{ $balance }}"
                                    {{ !$isSigned ? 'disabled' : '' }}>

                                    #{{ $proforma->id }} — {{ $proforma->vehicle_plate }}

                                    @if (!$isSigned)
                                        ❌ (No firmada)
                                    @elseif($balance <= 0)
                                        ✅ (Pagada)
                                    @else
                                        💰 (Saldo: ${{ number_format($balance, 2) }})
                                    @endif
                                </option>
                            @endforeach
                        </select>

                        <small class="form-text text-muted mt-1">
                            ⚠️ Solo se pueden registrar pagos para proformas <strong>firmadas por el cliente</strong>.
                        </small>

                    </div>
>>>>>>> 964613b02c73302aea2dc33386313b314db28634

                    {{-- INFO DINÁMICA --}}
                    <div class="row mt-3">
                        <div class="col-md-4">
                            <label>Total de la proforma</label>
                            <input type="text" id="proforma_total" class="form-control" readonly>
                        </div>

                        <div class="col-md-4">
                            <label>Total pagado</label>
                            <input type="text" id="proforma_paid" class="form-control" readonly>
                        </div>

                        <div class="col-md-4">
                            <label>Saldo pendiente</label>
                            <input type="text" id="proforma_balance" class="form-control" readonly>
                        </div>
                    </div>

                    {{-- MONTO --}}
                    <div class="form-group mt-3">
                        <label>Valor a cancelar</label>
                        <input type="number" step="0.01" name="amount" id="amount_input" class="form-control"
                            placeholder="Seleccione una proforma" required>
                        <div class="invalid-feedback">
                            El monto no puede superar el saldo pendiente.
                        </div>
                    </div>

                    {{-- MÉTODO --}}
                    <div class="form-group">
                        <label>Método de pago</label>
                        <select name="payment_method" class="form-control" required>
                            <option value="">-- Seleccione un método --</option>
                            <option value="cash">Efectivo</option>
                            <option value="transfer">Transferencia</option>
                            <option value="card">Tarjeta</option>
                        </select>
                    </div>

                    {{-- DESCRIPCIÓN --}}
                    <div class="form-group">
                        <label>Descripción / Referencia</label>
                        <textarea name="description" class="form-control" rows="3"
                            placeholder="Número de transacción, comprobante o notas"></textarea>
                    </div>

                </div>

                <div class="card-footer">
                    <a href="{{ route('payments.index') }}" class="btn btn-secondary">Cancelar</a>
                    <button type="submit" class="btn btn-primary">Guardar Pago</button>
                </div>

            </form>
        </div>

    </div>
@endsection

@push('scripts')
    <script>
<<<<<<< HEAD
        $(document).ready(function() {

            const totalInput = $('#proforma_total');
            const paidInput = $('#proforma_paid');
            const balanceInput = $('#proforma_balance');
            const amountInput = $('#amount_input');

            let currentBalance = 0;

            // Inicializar Select2
            const proformaSelect = $('#proforma_select').select2({
                placeholder: '-- Seleccione Proforma --',
                allowClear: true,
                width: '100%',
                minimumResultsForSearch: 0
            });

            // ✅ CUANDO SE SELECCIONA UNA PROFORMA
            proformaSelect.on('select2:select', function(e) {

                const option = e.params.data.element;
=======
        document.addEventListener('DOMContentLoaded', function() {

            const select = document.getElementById('proforma_select');
            const totalInput = document.getElementById('proforma_total');
            const paidInput = document.getElementById('proforma_paid');
            const balanceInput = document.getElementById('proforma_balance');
            const amountInput = document.getElementById('amount_input');

            let currentBalance = 0;

            select.addEventListener('change', function() {
                const option = this.options[this.selectedIndex];
                if (!option.value) return;
>>>>>>> 964613b02c73302aea2dc33386313b314db28634

                const total = parseFloat(option.dataset.total);
                const paid = parseFloat(option.dataset.paid);
                const balance = parseFloat(option.dataset.balance);

                currentBalance = balance;

<<<<<<< HEAD
                totalInput.val('$' + total.toFixed(2));
                paidInput.val('$' + paid.toFixed(2));
                balanceInput.val('$' + balance.toFixed(2));

                amountInput.val(balance.toFixed(2));
                amountInput.removeClass('is-invalid');
            });

            // ✅ CUANDO SE LIMPIA EL SELECT (X)
            proformaSelect.on('select2:clear', function() {

                totalInput.val('');
                paidInput.val('');
                balanceInput.val('');
                amountInput.val('');
                currentBalance = 0;
            });

            // ✅ VALIDACIÓN DEL MONTO
            amountInput.on('input', function() {
=======
                totalInput.value = '$' + total.toFixed(2);
                paidInput.value = '$' + paid.toFixed(2);
                balanceInput.value = '$' + balance.toFixed(2);

                amountInput.value = balance.toFixed(2);
                amountInput.classList.remove('is-invalid');
            });

            amountInput.addEventListener('input', function() {
>>>>>>> 964613b02c73302aea2dc33386313b314db28634
                const entered = parseFloat(this.value) || 0;

                if (entered > currentBalance) {
                    this.classList.add('is-invalid');
                } else {
                    this.classList.remove('is-invalid');
                }
            });

        });
    </script>
@endpush
<<<<<<< HEAD
@push('styles')
    <style>
        /* ===== FIX SELECT2 + ADMINLTE ===== */

        .select2-container .select2-selection--single {
            height: 38px !important;
            /* Altura estándar Bootstrap */
            padding: 4px 10px;
            border: 1px solid #ced4da;
            border-radius: 4px;
            display: flex;
            align-items: center;
        }

        .select2-selection__rendered {
            line-height: normal !important;
            padding-left: 0 !important;
            color: #495057;
        }

        .select2-selection__arrow {
            height: 36px !important;
            top: 1px !important;
        }

        /* Focus */
        .select2-container--default.select2-container--focus .select2-selection--single {
            border-color: #80bdff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, .25);
        }

        /* Disabled */
        .select2-container--default .select2-results__option[aria-disabled=true] {
            color: #dc3545;
            font-weight: 500;
        }
    </style>
@endpush
=======
>>>>>>> 964613b02c73302aea2dc33386313b314db28634
