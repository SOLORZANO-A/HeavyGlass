<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Historial de Pagos</title>

    <style>
        body { font-family: DejaVu Sans; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #000; padding: 6px; }
        th { background: #f0f0f0; }
        h2 { text-align: center; }
    </style>
</head>
<body>

<h2>Historial Completo de Pagos</h2>

<table>
    <thead>
        <tr>
            <th>#</th>
            <th>Comprobante</th>
            <th>Cliente</th>
            <th>Vehículo</th>
            <th>Monto</th>
            <th>Método</th>
            <th>Estado</th>
            <th>Fecha</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($payments as $payment)
            <tr>
                <td>{{ $payment->id }}</td>
                <td>{{ $payment->receipt_number }}</td>
                <td>{{ $payment->proforma->client_name ?? '—' }}</td>
                <td>{{ $payment->proforma->vehicle_plate ?? '—' }}</td>
                <td>${{ number_format($payment->amount, 2) }}</td>
                <td>{{ ucfirst($payment->payment_method) }}</td>
                <td>{{ ucfirst($payment->status) }}</td>
                <td>{{ $payment->created_at->format('Y-m-d') }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>
