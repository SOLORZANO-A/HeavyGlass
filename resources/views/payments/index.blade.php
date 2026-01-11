@extends('layouts.app')

@section('title', 'Pagos')

@section('content')
    <div class="container-fluid">

        <div class="card shadow-sm">

            {{-- ================= HEADER ================= --}}
            <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
                <h3 class="card-title mb-0">
                    <i class="fas fa-money-bill-wave mr-1"></i> Pagos
                </h3>

                <div class="d-flex gap-2">
                    <a href="{{ route('payments.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Registrar Pago
                    </a>

                    @role('admin')
                        <a href="{{ route('payments.history') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="fas fa-history"></i> Historial de Pagos
                        </a>
                    @endrole
                </div>
            </div>

            {{-- ================= FILTRO + EXPORT ================= --}}
            <div class="card-body border-bottom">

                <div class="row mb-3">
                    <div class="col-md-5 mb-2">
                        <input type="text" id="searchInput" class="form-control"
                            placeholder="🔍 Buscar por comprobante, cliente, vehículo...">
                    </div>

                    <div class="col-md-7 text-md-right">
                        <a href="{{ route('payments.export.pdf') }}" class="btn btn-danger btn-sm">
                            <i class="fas fa-file-pdf"></i> PDF
                        </a>

                        <a href="{{ route('payments.export.csv') }}" class="btn btn-success btn-sm ml-1">
                            <i class="fas fa-file-excel"></i> Excel
                        </a>
                    </div>
                </div>

                {{-- ================= TABLA ================= --}}
                <div class="table-responsive">
                    <table class="table table-hover table-bordered align-middle" id="FrmPagos">
                        <thead class="thead-light text-center">
                            <tr>
                                <th>ID</th>
                                <th>Cliente</th>
                                <th>Vehículo</th>
                                <th>Proforma</th>
                                <th>Monto</th>
                                <th>Método</th>
                                <th>Cajera/o</th>
                                <th>Fecha</th>
                                <th width="180">Opciones</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($payments as $payment)
                                <tr>
                                    <td class="text-center">{{ $payment->id }}</td>
                                    <td>{{ $payment->proforma->client_name ?? '—' }}</td>

                                    <td>
                                        {{ $payment->proforma->vehicle_brand }}
                                        {{ $payment->proforma->vehicle_model }}
                                        ({{ $payment->proforma->vehicle_plate }})
                                    </td>


                                    <td class="text-center">
                                        <span class="badge badge-info">
                                            #{{ $payment->proforma->id }}
                                        </span>
                                    </td>

                                    <td class="text-right font-weight-bold text-success">
                                        ${{ number_format($payment->amount, 2) }}
                                    </td>

                                    @php
                                        $methodLabels = [
                                            'cash' => 'Efectivo',
                                            'transfer' => 'Transferencia',
                                            'card' => 'Tarjeta',
                                        ];
                                    @endphp

                                    <td class="text-center">
                                        <span class="badge badge-secondary">
                                            {{ $methodLabels[$payment->payment_method] ?? '—' }}
                                        </span>
                                    </td>

                                    <td>{{ $payment->cashier?->fullName() ?? '—' }}</td>

                                    <td class="text-center">
                                        {{ $payment->paid_at?->format('Y-m-d') ?? '—' }}
                                    </td>

                                    <td class="text-center">

                                        <a href="{{ route('payments.show', $payment) }}" class="btn btn-info btn-sm"
                                            title="Ver">
                                            <i class="fas fa-eye"></i>
                                        </a>

                                        <a href="{{ route('payments.edit', $payment) }}" class="btn btn-warning btn-sm"
                                            title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        {{-- ANULAR (CAJERA + ADMIN) --}}
                                        @can('manage payments')
                                            <form action="{{ route('payments.cancel', $payment) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('PATCH')

                                                <button type="button" class="btn btn-warning btn-sm" data-confirm
                                                    data-title="¿Anular pago?" data-text="El pago será marcado como cancelado"
                                                    data-confirm="Sí, anular">
                                                    <i class="fas fa-ban"></i>
                                                </button>
                                            </form>
                                        @endcan

                                        {{-- ELIMINAR (SOLO ADMIN) --}}
                                        @role('admin')
                                            <form action="{{ route('payments.destroy', $payment) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')

                                                <button type="button" class="btn btn-danger btn-sm" data-confirm
                                                    data-title="¿Eliminar pago?"
                                                    data-text="El pago será eliminado definitivamente"
                                                    data-confirm="Sí, eliminar">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        @endrole
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted">
                                        No hay pagos registrados
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- ================= PAGINACIÓN ================= --}}
            <div class="card-footer clearfix">
                {{ $payments->links() }}
            </div>

        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.getElementById('searchInput').addEventListener('keyup', function() {
            const value = this.value.toLowerCase();
            const rows = document.querySelectorAll('#FrmPagos tbody tr');

            rows.forEach(row => {
                row.style.display = row.innerText.toLowerCase().includes(value) ?
                    '' :
                    'none';
            });
        });
    </script>
@endpush
