@extends('layouts.app')

@section('title', 'Historial de Pagos')

@section('content')
<div class="container-fluid">

    <div class="card card-outline card-secondary">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-history"></i>
                Historial completo de pagos
            </h3>

            <div class="card-tools">
                <a href="{{ route('payments.index') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-arrow-left"></i> Pagos activos
                </a>
            </div>
        </div>

        <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Comprobante</th>
                        <th>Proforma</th>
                        <th>Monto</th>
                        <th>Método</th>
                        <th>Estado</th>
                        <th>Fecha</th>
                        <th>Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($payments as $payment)
                        <tr class="{{ $payment->status === 'cancelled' ? 'table-danger' : '' }}">

                            <td>{{ $payment->id }}</td>

                            <td>
                                <strong>{{ $payment->receipt_number }}</strong>
                            </td>

                            <td>
                                #{{ $payment->proforma_id }}
                            </td>

                            <td>
                                ${{ number_format($payment->amount, 2) }}
                            </td>

                            <td>
                                {{ ucfirst($payment->payment_method) }}
                            </td>

                            <td>
                                @if ($payment->status === 'valid')
                                    <span class="badge badge-success">
                                        VÁLIDO
                                    </span>
                                @else
                                    <span class="badge badge-danger">
                                        ANULADO
                                    </span>
                                @endif
                            </td>

                            <td>
                                {{ $payment->paid_at?->format('Y-m-d H:i') ?? '—' }}
                            </td>

                            <td>
                                <a href="{{ route('payments.show', $payment) }}"
                                   class="btn btn-info btn-sm"
                                   title="Ver comprobante">
                                    <i class="fas fa-eye"></i>
                                </a>

                                @if ($payment->status === 'cancelled')
                                    <span class="text-muted ml-2">
                                        <i class="fas fa-lock"></i>
                                    </span>
                                @endif
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted py-4">
                                No existen pagos registrados
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="card-footer clearfix">
            {{ $payments->links() }}
        </div>
    </div>

</div>
@endsection
