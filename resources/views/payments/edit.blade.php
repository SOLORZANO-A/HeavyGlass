@extends('layouts.app')

@section('title', 'Editar Pago')

@section('content')
    <div class="container-fluid">

        <div class="card card-warning">
            <div class="card-header">
                <h3 class="card-title">Editar Pago</h3>
            </div>

            <form action="{{ route('payments.update', $payment) }}" method="POST">
                @csrf
                @method('PUT')

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
                    <div class="form-group">
                        <label>Proforma</label>
                        <select name="proforma_id" id="proforma_select" class="form-control" required>

                            @foreach ($proformas as $proforma)
                                @php
                                    $paid = $proforma->payments->where('status', 'valid')->sum('amount');

                                    // 🔑 devolver el monto actual al saldo
                                    if ($payment->proforma_id == $proforma->id) {
                                        $paid -= $payment->amount;
                                    }

                                    $balance = round($proforma->total - $paid, 2);
                                    $isSigned = $proforma->signature_status === 'signed';
                                @endphp

                                <option value="{{ $proforma->id }}" data-total="{{ $proforma->total }}"
                                    data-paid="{{ $paid }}" data-balance="{{ $balance }}"
                                    {{ $payment->proforma_id == $proforma->id ? 'selected' : '' }}
                                    {{ !$isSigned ? 'disabled' : '' }}>

                                    #{{ $proforma->id }} — {{ $proforma->vehicle_plate }}
                                </option>
                            @endforeach
                        </select>

                        <small class="text-muted">
                            ⚠️ Solo proformas firmadas pueden recibir pagos.
                        </small>
                    </div>

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

                    {{-- CAJERO --}}
                    <div class="form-group mt-3">
                        <label>Cajera/o</label>
                        <select name="cashier_id" class="form-control" required>
                            @foreach ($cashiers as $cashier)
                                <option value="{{ $cashier->id }}"
                                    {{ $payment->cashier_id == $cashier->id ? 'selected' : '' }}>
                                    {{ $cashier->fullName() }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- MONTO --}}
                    <div class="form-group">
                        <label>Cantidad a pagar</label>
                        <input type="number" step="0.01" name="amount" id="amount_input" class="form-control"
                            value="{{ old('amount', $payment->amount) }}" required>

                        <div class="invalid-feedback">
                            El monto no puede superar el saldo pendiente.
                        </div>
                    </div>

                    {{-- MÉTODO --}}
                    <div class="form-group">
                        <label>Método de pago</label>
                        <select name="payment_method" class="form-control" required>
                            <option value="cash" {{ $payment->payment_method == 'cash' ? 'selected' : '' }}>Efectivo
                            </option>
                            <option value="transfer" {{ $payment->payment_method == 'transfer' ? 'selected' : '' }}>
                                Transferencia</option>
                            <option value="card" {{ $payment->payment_method == 'card' ? 'selected' : '' }}>Tarjeta
                            </option>
                        </select>
                    </div>

                    {{-- DESCRIPCIÓN --}}
                    <div class="form-group">
                        <label>Descripción</label>
                        <textarea name="description" class="form-control" rows="3">
                        {{ old('description', $payment->description) }}
                    </textarea>
                    </div>

                </div>

                <div class="card-footer">
                    <a href="{{ route('payments.index') }}" class="btn btn-secondary">
                        Cancelar
                    </a>

                    <button type="submit" class="btn btn-warning">
                        Actualizar Pago
                    </button>
                </div>

            </form>
        </div>

    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const select = document.getElementById('proforma_select');
            const totalInput = document.getElementById('proforma_total');
            const paidInput = document.getElementById('proforma_paid');
            const balanceInput = document.getElementById('proforma_balance');
            const amountInput = document.getElementById('amount_input');

            let currentBalance = 0;

            function updateInfo() {
                const option = select.options[select.selectedIndex];
                if (!option) return;

                const total = parseFloat(option.dataset.total);
                const paid = parseFloat(option.dataset.paid);
                const balance = parseFloat(option.dataset.balance);

                currentBalance = balance;

                totalInput.value = '$' + total.toFixed(2);
                paidInput.value = '$' + paid.toFixed(2);
                balanceInput.value = '$' + balance.toFixed(2);
            }

            select.addEventListener('change', updateInfo);

            amountInput.addEventListener('input', function() {
                const entered = parseFloat(this.value) || 0;
                if (entered > currentBalance) {
                    this.classList.add('is-invalid');
                } else {
                    this.classList.remove('is-invalid');
                }
            });

            updateInfo(); // 🔥 inicial
        });
    </script>
@endpush
