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
        'search' => 'required|string|min:2'
    ]);

    $search = trim($request->search);

    $proformas = Proforma::with([
            'details',
            'payments',
            'workOrder.technicians'
        ])
        ->where('vehicle_plate', 'LIKE', "%{$search}%")
        ->orWhere('id', $search)
        ->orderBy('created_at', 'desc')
        ->get();

    if ($proformas->isEmpty()) {
        return back()->withErrors(
            'No se encontró información con los datos ingresados.'
        );
    }

    return view('public.result', compact('proformas', 'search'));
}

}
