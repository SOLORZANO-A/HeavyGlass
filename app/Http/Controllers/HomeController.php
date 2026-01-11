<?php

namespace App\Http\Controllers;
use App\Models\Proforma;
    use App\Models\Payment;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    

    public function index()
    {
        return view('dashboard', [
            'totalProformas'        => Proforma::count(),
            'proformasFirmadas'     => Proforma::where('signature_status', 'signed')->count(),
            'proformasPendientes'   => Proforma::where('signature_status', '!=', 'signed')->count(),
            'ingresos'              => Payment::where('status', 'valid')->sum('amount'),
        ]);
    }
}
