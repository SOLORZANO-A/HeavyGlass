<?php
namespace App\Http\Controllers;

use App\Models\Proforma;
use App\Models\Payment;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;


class ReportController extends Controller
{
    public function proformas(Request $request)
    {
         $from = $request->from;
    $to   = $request->to;

    $proformasQuery = Proforma::query();
    $paymentsQuery  = Payment::where('status', 'valid');

    if ($from && $to) {
        $proformasQuery->whereBetween('created_at', [
            $from . ' 00:00:00',
            $to   . ' 23:59:59'
        ]);

        $paymentsQuery->whereBetween('paid_at', [
            $from . ' 00:00:00',
            $to   . ' 23:59:59'
        ]);
    }

    $totalProformas = $proformasQuery->count();

    $firmadas = (clone $proformasQuery)
        ->where('signature_status', 'signed')
        ->count();

    $noFirmadas = (clone $proformasQuery)
        ->where('signature_status', '!=', 'signed')
        ->count();

    $ingresos = $paymentsQuery->sum('amount');

    return view('reports.proformas', compact(
        'totalProformas',
        'firmadas',
        'noFirmadas',
        'ingresos'
    ));
    }
   

public function proformasIngresosPdf(Request $request)
{
    $from = $request->from;
    $to   = $request->to;

    $proformas = Proforma::whereBetween('created_at', [
            $from . ' 00:00:00',
            $to   . ' 23:59:59'
        ])
        ->orderBy('created_at', 'asc')
        ->get();

    $data = [
        'from' => $from,
        'to'   => $to,
        'proformas' => $proformas,
        'totalProformas' => $proformas->count(),
        'firmadas' => $proformas->where('signature_status', 'signed')->count(),
        'noFirmadas' => $proformas->where('signature_status', '!=', 'signed')->count(),
        'ingresos' => Payment::where('status', 'valid')
            ->whereBetween('paid_at', [
                $from . ' 00:00:00',
                $to   . ' 23:59:59'
            ])->sum('amount'),
    ];

    return Pdf::loadView('reports.proformas_pdf', $data)
        ->download('reporte_proformas_' . now()->format('Ymd_His') . '.pdf');
}


}
