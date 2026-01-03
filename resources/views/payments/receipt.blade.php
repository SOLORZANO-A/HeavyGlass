<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Comprobante de Pago</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 13px;
            margin: 40px;
            color: #111;
        }
        .header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
        }
        .title {
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 25px;
        }
        .box {
            border: 1px solid #ccc;
            padding: 15px;
            margin-bottom: 20px;
        }
        .box p {
            margin: 5px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        td {
            padding: 8px;
            border-bottom: 1px solid #ddd;
        }
        .label {
            font-weight: bold;
        }
        .right {
            text-align: right;
        }
        .total {
            font-size: 15px;
            font-weight: bold;
        }
        .footer {
            margin-top: 35px;
            text-align: right;
        }
    </style>
</head>
<body>

<div class="header">
    <div>
        <strong>TALLER AUTOMOTRIZ</strong><br>
        Comprobante de Pago
    </div>
    <div class="right">
        <strong>N°:</strong> {{ $payment->receipt_number }}<br>
        <strong>Fecha:</strong> {{ $payment->paid_at->format('d/m/Y H:i') }}
    </div>
</div>

<div class="title">COMPROBANTE DE PAGO</div>

<div class="box">
    <p><strong>Cliente:</strong> {{ $proforma->client_name }}</p>
    <p><strong>Cédula:</strong> {{ $proforma->client_document }}</p>
    <p><strong>Teléfono:</strong> {{ $proforma->client_phone }}</p>
    <p><strong>Email:</strong> {{ $proforma->client_email }}</p>
</div>

<div class="box">
    <p>
        <strong>Vehículo:</strong>
        {{ $proforma->vehicle_brand }}
        {{ $proforma->vehicle_model }}
        ({{ $proforma->vehicle_plate }})
    </p>
</div>

<div class="box">
    <table>
        <tr>
            <td class="label">Total Proforma</td>
            <td class="right">${{ number_format($totalProforma, 2) }}</td>
        </tr>
        <tr>
            <td class="label">Total Pagado</td>
            <td class="right">${{ number_format($totalPagado, 2) }}</td>
        </tr>
        <tr>
            <td class="label">Saldo Pendiente</td>
            <td class="right">${{ number_format($saldo, 2) }}</td>
        </tr>
        <tr>
            <td class="label total">Monto de este pago</td>
            <td class="right total">${{ number_format($payment->amount, 2) }}</td>
        </tr>
        <tr>
            <td class="label">Método de pago</td>
            <td class="right">{{ ucfirst($payment->payment_method) }}</td>
        </tr>
    </table>
</div>

<div class="footer">
    <strong>Cajero:</strong> {{ $payment->cashier->fullName() ?? '—' }}
</div>

</body>
</html>
