<?php

namespace App\Http\Controllers;

use App\Models\Proforma;
use Illuminate\Http\Request;

class PublicVehicleStatusController extends Controller
{
    public function consult()
    {
        return view('public.consult');
    }

    public function search(Request $request)
    {
        $request->validate([
            'plate'    => 'required|string|min:5',
            'document' => 'required|string|min:8',
        ]);

        $plate    = strtoupper(trim($request->plate));
        $document = trim($request->document);

        $proformas = Proforma::with([
            'details',
            'payments',
            'workOrder.technicians'
        ])
            ->where('vehicle_plate', $plate)
            ->where('client_document', $document)
            ->orderBy('created_at', 'desc')
            ->get();

        if ($proformas->isEmpty()) {
            return back()->withErrors(
                'No se encontró información con los datos ingresados. Verifique placa y cédula.'
            );
        }

        return view('public.result', compact('proformas', 'plate'));
    }
}
