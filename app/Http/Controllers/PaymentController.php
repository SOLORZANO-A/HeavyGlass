<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Proforma;
use App\Models\Profile;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;


class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::valid()
            ->latest()
            ->paginate(10); // 👈 IMPORTANTE

        return view('payments.index', compact('payments'));
    }

    public function history()
    {
        $payments = Payment::latest()
            ->paginate(15);

        return view('payments.history', compact('payments'));
    }



    public function create()
    {
        $proformas = Proforma::whereIn('status', ['pending', 'partial'])
            ->with('payments')
            ->orderBy('created_at', 'desc')
            ->get();


        $cashiers = Profile::where('staff_type', 'cashier')
            ->orderBy('first_name')
            ->get();

        return view('payments.create', compact('proformas', 'cashiers'));
    }

    protected function getCashierProfile()
    {
        $user = auth()->user();

        if (!$user) {
            abort(401, 'Usuario no autenticado');
        }

        if (!$user->profile) {
            abort(403, 'El usuario no tiene perfil asociado. Contacte al administrador.');
        }

        return $user->profile;
    }
    public function store(Request $request)
    {


        $data = $request->validate([
            'proforma_id'    => 'required|exists:proformas,id',
            'amount'         => 'required|numeric|min:0.01',
            'payment_method' => 'required|in:cash,transfer,card',
            'description'    => 'nullable|string|max:255',
        ]);



        // ✅ PERFIL SEGURO (admin o cajera)
        $cashierProfile = $this->getCashierProfile();

        return DB::transaction(function () use ($data, $cashierProfile) {

            $proforma = Proforma::with('payments')
                ->lockForUpdate()
                ->findOrFail($data['proforma_id']);

            // ❌ NO permitir pagos si la proforma no está firmada
            if ($proforma->signature_status !== 'signed') {
                return back()
                    ->withErrors([
                        'proforma_id' => 'La proforma debe estar firmada por el cliente antes de registrar pagos.'
                    ])
                    ->withInput();
            }


            // 🔢 Cálculos
            $totalPaid = $proforma->payments()
                ->where('status', 'valid')
                ->sum('amount');

            $balance   = round($proforma->total - $totalPaid, 2);

            // ❌ Validación crítica
            if ($data['amount'] > $balance) {
                return back()
                    ->withErrors([
                        'amount' => "El monto ingresado supera el saldo pendiente ($" . number_format($balance, 2) . ")."
                    ])
                    ->withInput();
            }

            // 🧾 Número de comprobante
            $lastNumber = Payment::max('id') + 1;

            $receiptNumber = 'RC-' . now()->format('Y') . '-' .
                str_pad($lastNumber, 6, '0', STR_PAD_LEFT);


            // ✅ Registrar pago
            $payment = Payment::create([
                'proforma_id'    => $proforma->id,
                'cashier_id'     => $cashierProfile->id, // 👈 PERFIL REAL
                'amount'         => $data['amount'],
                'payment_method' => $data['payment_method'],
                'description'    => $data['description'] ?? null,
                'receipt_number' => $receiptNumber,
                'issued_at'      => now(),
                'paid_at'        => now(),
            ]);

            // 🔁 Estado de la proforma
            $newPaid = round($totalPaid + $data['amount'], 2);

            $status = match (true) {
                $newPaid <= 0 => 'pending',
                $newPaid < $proforma->total => 'partial',
                default => 'paid',
            };

            $proforma->update(['status' => $status]);



            return redirect()
                ->route('payments.show', $payment)
                ->with('success', 'Pago registrado y comprobante generado correctamente');
        });
    }







    public function show(Payment $payment)
{
    $payment->load(['proforma.payments', 'cashier']);

    $total = $payment->proforma->total;

    // Pagos válidos acumulados
    $rawTotalPaid = $payment->proforma->payments
        ->where('status', 'valid')
        ->sum('amount');

    // 🔒 Total pagado NO puede superar el total de la proforma
    $totalPaid = min($total, round($rawTotalPaid, 2));

    // 🔒 Saldo pendiente nunca negativo
    $balance = max(0, round($total - $totalPaid, 2));

    return view('payments.show', compact(
        'payment',
        'total',
        'totalPaid',
        'balance'
    ));
}





    public function edit(Payment $payment)
    {
        $proformas = Proforma::orderBy('created_at', 'desc')->get();

        $cashiers = Profile::where('staff_type', 'cashier')
            ->orderBy('first_name')
            ->get();

        return view('payments.edit', compact('payment', 'proformas', 'cashiers'));
    }

    public function update(Request $request, Payment $payment)
    {
        $data = $request->validate([
            'proforma_id'    => 'required|exists:proformas,id',
            'cashier_id'     => 'required|exists:profiles,id',
            'amount'         => 'required|numeric|min:0.01',
            'payment_method' => 'required|string|max:50',
            'description'    => 'nullable|string',
        ]);

        // 1️⃣ Actualizar el pago
        $payment->update([
            'proforma_id'    => $data['proforma_id'],
            'cashier_id'     => $data['cashier_id'],
            'amount'         => $data['amount'],
            'payment_method' => $data['payment_method'],
            'description'    => $data['description'] ?? null,
        ]);

        // 2️⃣ Obtener la proforma
        $proforma = $payment->proforma;

        // 3️⃣ Recalcular total pagado
        $totalPaid = $proforma->payments()
            ->where('status', 'valid')
            ->sum('amount');


        // 4️⃣ Determinar nuevo estado
        if ($totalPaid == 0) {
            $status = 'pending';
        } elseif ($totalPaid < $proforma->total) {
            $status = 'partial';
        } else {
            $status = 'paid';
        }

        // 5️⃣ Actualizar estado de la proforma
        $proforma->update([
            'status' => $status,
        ]);

        return redirect()
            ->route('payments.index')
            ->with('success', 'Payment updated successfully');
    }


    public function destroy(Payment $payment)
{
    DB::transaction(function () use ($payment) {

        $proforma = $payment->proforma;

        // 1️⃣ Eliminar pago
        $payment->delete();

        // 2️⃣ Recalcular pagos válidos
        $totalPagado = $proforma->payments()
            ->where('status', 'valid')
            ->sum('amount');

        // 3️⃣ Determinar nuevo estado
        $status = match (true) {
            $totalPagado <= 0 => 'pending',
            $totalPagado < $proforma->total => 'partial',
            default => 'paid',
        };

        // 4️⃣ Actualizar proforma
        $proforma->update([
            'status' => $status
        ]);
    });

    return redirect()
        ->route('payments.index')
        ->with('success', 'Pago eliminado y proforma actualizada correctamente');
}


    public function cancel(Payment $payment)
    {
        DB::transaction(function () use ($payment) {

            // 1️⃣ Anular pago
            $payment->update([
                'status' => 'cancelled'
            ]);

            // 2️⃣ Recalcular estado de la proforma
            $proforma = $payment->proforma;

            $totalPagado = $proforma->payments()
                ->where('status', 'valid')
                ->sum('amount');

            $status = match (true) {
                $totalPagado <= 0 => 'pending',
                $totalPagado < $proforma->total => 'partial',
                default => 'paid',
            };

            $proforma->update(['status' => $status]);
        });

        return redirect()
            ->route('payments.index')
            ->with('success', 'Pago anulado correctamente');
    }




    public function receipt(Payment $payment)
    {
        $proforma = $payment->proforma;

        // 🔢 Cálculos centralizados
        $totalProforma = (float) $proforma->total;
        $totalPagado = (float) $proforma->payments()
            ->where('status', 'valid')
            ->sum('amount');

        $saldo         = round($totalProforma - $totalPagado, 2);

        return Pdf::loadView('payments.receipt', [
            'payment'        => $payment,
            'proforma'       => $proforma,
            'totalProforma'  => $totalProforma,
            'totalPagado'    => $totalPagado,
            'saldo'          => $saldo,
        ])->stream();
    }
    public function exportPdf()
    {
        $payments = Payment::with('proforma')
            ->latest()
            ->get();

        return Pdf::loadView('payments.exports.pdf', compact('payments'))
            ->download('historial_pagos.pdf');
    }
    public function exportCsv()
    {
        $payments = Payment::with(['proforma', 'cashier'])
            ->orderBy('created_at', 'desc')
            ->get();

        $fileName = 'historial_pagos_' . now()->format('Ymd_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=$fileName",
        ];

        $callback = function () use ($payments) {
            $file = fopen('php://output', 'w');

            // BOM para Excel (muy importante)
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));

            // CABECERAS
            fputcsv($file, [
                'ID Pago',
                'Fecha',
                'Proforma',
                'Cliente',
                'Vehículo',
                'Monto',
                'Método',
                'Estado',
                'Cajero',
            ]);

            foreach ($payments as $payment) {
                fputcsv($file, [
                    $payment->id,
                    $payment->created_at->format('Y-m-d H:i'),
                    $payment->proforma_id,
                    $payment->proforma->client_name ?? '—',
                    $payment->proforma->vehicle_plate ?? '—',
                    number_format($payment->amount, 2, '.', ''),
                    ucfirst($payment->payment_method),
                    ucfirst($payment->status),
                    $payment->cashier?->fullName() ?? '—',
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
