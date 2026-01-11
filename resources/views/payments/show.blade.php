@extends('layouts.app')

@section('title', 'Comprobante de Pago')

@php
    $proforma = $payment->proforma;

    $total = $proforma?->total ?? 0;
    $paid = $proforma?->payments->sum('amount') ?? 0;
    $balance = round($total - $paid, 2);
@endphp

@section('content')
    <div class="container-fluid">

        <div class="card card-info">

            {{-- CABECERA --}}
            <div class="card-header">
                <h3 class="card-title">
                    🧾 Comprobante de Pago
                </h3>

                <div class="card-tools">
                    <a href="{{ route('payments.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left"></i> Volver
                    </a>
                </div>
            </div>

            {{-- CUERPO --}}
            <div class="card-body">

                <table class="table table-bordered">

                    <tr>
                        <th width="250">N° de Comprobante</th>
                        <td><strong>{{ $payment->receipt_number ?? '—' }}</strong></td>
                    </tr>

                    <tr>
                        <th>Fecha de emisión</th>
                        <td>{{ optional($payment->issued_at)->format('Y-m-d H:i') ?? '—' }}</td>
                    </tr>

                    <tr>
                        <th>Proforma</th>
                        <td>
                            @if ($proforma)
                                #{{ $proforma->id }}
                            @else
                                —
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <th>Cliente</th>
                        <td>{{ $payment->proforma->client_name ?? '—' }}</td>
                    </tr>


                    <tr>
                        <th>Vehículo</th>
                        <td>
                            {{ $proforma?->vehicle_brand ?? '' }}
                            {{ $proforma?->vehicle_model ?? '' }}
                            <small class="text-muted">
                                ({{ $proforma?->vehicle_plate ?? '—' }})
                            </small>
                        </td>
                    </tr>

                    <tr>
                        <th>Total de la proforma</th>
                        <td><strong>${{ number_format($total, 2) }}</strong></td>
                    </tr>

                    <tr>
                        <th>Total pagado</th>
                        <td class="text-success">
                            ${{ number_format($totalPaid, 2) }}
                        </td>
                    </tr>


                    <tr>
                        <th>Saldo pendiente</th>
                        <td>
                            @if ($balance > 0)
                                <span class="badge badge-warning">
                                    ${{ number_format($balance, 2) }}
                                </span>
                            @else
                                <span class="badge badge-success">
                                    PAGADO
                                </span>
                            @endif
                        </td>
                    </tr>



                    <tr>
                        <th>Monto de este pago</th>
                        <td>
                            <strong class="text-success">
                                ${{ number_format($payment->amount, 2) }}
                            </strong>
                        </td>
                    </tr>

                    <tr>
                        <th>Método de pago</th>
                        <td>
                            {{ [
                                'cash' => 'Efectivo',
                                'transfer' => 'Transferencia',
                                'card' => 'Tarjeta',
                            ][$payment->payment_method] ?? '—' }}
                        </td>
                    </tr>

                    <tr>
                        <th>Referencia / Observación</th>
                        <td>{{ $payment->description ?? '—' }}</td>
                    </tr>

                    <tr>
                        <th>Cajera</th>
                        <td>
                            {{ $payment->cashier?->fullName() ?? '—' }}
                        </td>
                    </tr>

                    <tr>
                        <th>Estado de la proforma</th>
                        <td>
                            @php
                                $statusLabels = [
                                    'pending' => 'Pendiente',
                                    'partial' => 'Pago parcial',
                                    'paid' => 'Pagada',
                                ];
                            @endphp

                            <span class="badge badge-info">
                                {{ $statusLabels[$proforma?->status] ?? '—' }}
                            </span>
                        </td>
                    </tr>

                </table>

            </div>

            {{-- PIE --}}
            <div class="card-footer text-right">
                <a href="{{ route('payments.index') }}" class="btn btn-secondary">
                    Volver
                </a>

                {{-- preparado para el siguiente paso --}}
                <button onclick="window.print()" class="btn btn-primary">
                    <i class="fas fa-print"></i> Imprimir
                </button>

                @canany(['manage payments', 'admin'])
                    <a href="{{ route('payments.receipt', $payment) }}" target="_blank" class="btn btn-danger">
                        <i class="fas fa-file-pdf"></i>
                        Ver comprobante PDF
                    </a>
                @endcanany




            </div>

        </div>

    </div>
@endsection
