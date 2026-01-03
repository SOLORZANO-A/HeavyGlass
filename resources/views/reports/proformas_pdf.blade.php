<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Reporte de Proformas</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
        }

        h2 {
            text-align: center;
            margin-bottom: 5px;
        }

        .range {
            text-align: center;
            margin-bottom: 15px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #333;
            padding: 6px;
        }

        th {
            background: #f0f0f0;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }
    </style>
</head>

<body>

    <h2>Reporte de Proformas e Ingresos</h2>

    <div class="range">
        Desde <strong>{{ $from }}</strong> hasta <strong>{{ $to }}</strong>
    </div>

    <table style="margin-bottom:15px">
        <tr>
            <th>Total Proformas</th>
            <td>{{ $totalProformas }}</td>
            <th>Firmadas</th>
            <td>{{ $firmadas }}</td>
            <th>No Firmadas</th>
            <td>{{ $noFirmadas }}</td>
            <th>Ingresos</th>
            <td>${{ number_format($ingresos, 2) }}</td>
        </tr>
    </table>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Cliente</th>
                <th>Vehículo</th>
                <th>Total</th>
                <th>Fecha</th>
                <th>Pago</th>
                <th>Firma</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($proformas as $proforma)
                <tr>
                    <td class="text-center">{{ $proforma->id }}</td>
                    <td>{{ $proforma->client_name }}</td>
                    <td>
                        {{ $proforma->vehicle_brand }}
                        {{ $proforma->vehicle_model }}
                        ({{ $proforma->vehicle_plate }})
                    </td>
                    @php
                        $pagado = $proforma->payments->where('status', 'valid')->sum('amount');

                        $pendiente = $proforma->total - $pagado;
                    @endphp

                    <td class="text-right">
                        @if ($proforma->status === 'paid')
                            ${{ number_format($pagado, 2) }}
                        @elseif($proforma->status === 'partial')
                            ${{ number_format($pagado, 2) }}
                            <br>
                            <small>(faltan ${{ number_format($pendiente, 2) }})</small>
                        @else
                            $0.00
                            <br>
                            <small>(faltan ${{ number_format($proforma->total, 2) }})</small>
                        @endif
                    </td>

                    <td class="text-center">
                        {{ $proforma->created_at->format('Y-m-d') }}
                    </td>
                    <td class="text-center">
                        {{ ucfirst($proforma->status) }}
                    </td>
                    <td class="text-center">
                        {{ $proforma->signature_status === 'signed' ? 'Sí' : 'No' }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>
