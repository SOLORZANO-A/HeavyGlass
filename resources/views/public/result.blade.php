<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Estado del Vehículo</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>

<body class="bg-light">

    <div class="container mt-5">

        <h3 class="mb-4 text-center">
            Historial del vehículo: <strong>{{ $plate }}</strong>
        </h3>

        @foreach ($proformas as $proforma)
            @php
                $paid = $proforma->payments->where('status', 'valid')->sum('amount');

                $balance = $proforma->total - $paid;
            @endphp

            <div class="card mb-4 shadow-sm">

                <div class="card-header bg-primary text-white">
                    Proforma #{{ $proforma->id }} •
                    {{ $proforma->created_at->format('d/m/Y') }}
                </div>

                <div class="card-body">

                    {{-- DATOS GENERALES --}}
                    <p><strong>Cliente:</strong> {{ $proforma->client_name }}</p>
                    <p><strong>Vehículo:</strong>
                        {{ $proforma->vehicle_brand }}
                        {{ $proforma->vehicle_model }}
                        ({{ $proforma->vehicle_plate }})
                    </p>

                    <p><strong>Técnico encargado:</strong><br>
                        @if ($proforma->workOrder && $proforma->workOrder->technicians->isNotEmpty())
                            @foreach ($proforma->workOrder->technicians as $technician)
                                <span class="badge bg-info text-dark me-1">
                                    {{ $technician->fullName() }}
                                    @if ($technician->specialization)
                                        ({{ $technician->specialization }})
                                    @endif
                                </span>
                            @endforeach
                        @else
                            <span class="text-muted">Pendiente de asignación</span>
                        @endif
                    </p>





                    <p><strong>Observaciones / Estado:</strong><br>
                        @if ($proforma->workOrder && $proforma->workOrder->description)
                            {{ $proforma->workOrder->description }}
                        @else
                            <span class="text-muted">Sin observaciones registradas</span>
                        @endif
                    </p>


                    {{-- DETALLES --}}
                    <hr>
                    <h6>Detalle de trabajos</h6>

                    <table class="table table-sm table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th>Descripción</th>
                                <th class="text-center">Cant.</th>
                                <th class="text-end">Precio Unit.</th>
                                <th class="text-end">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($proforma->details as $detail)
                                <tr>
                                    <td>{{ $detail->item_description }}</td>
                                    <td class="text-center">{{ $detail->quantity }}</td>
                                    <td class="text-end">
                                        ${{ number_format($detail->unit_price, 2) }}
                                    </td>
                                    <td class="text-end">
                                        ${{ number_format($detail->line_total, 2) }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {{-- TOTALES --}}
                    <p class="mt-2">
                        <strong>Total:</strong>
                        ${{ number_format($proforma->total, 2) }}
                    </p>

                    {{-- PAGO --}}
                    <p>
                        <strong>Estado de pago:</strong>
                        @if ($balance <= 0)
                            <span class="badge bg-success">
                                Pagado (${{ number_format($paid, 2) }})
                            </span>
                        @else
                            <span class="badge bg-warning text-dark">
                                Abonado ${{ number_format($paid, 2) }}
                                (Falta ${{ number_format($balance, 2) }})
                            </span>
                        @endif
                    </p>

                    {{-- FIRMA --}}
                    <p>
                        <strong>Aprobación del cliente:</strong>
                        @if ($proforma->isSigned())
                            <span class="badge bg-success">Aceptada</span>
                        @else
                            <span class="badge bg-secondary">Pendiente</span>
                        @endif
                    </p>

                </div>
            </div>
        @endforeach

        <div class="text-center mt-4 text-muted small">
            HEAVY GLASS • Consulta pública informativa
        </div>

    </div>

</body>

</html>
