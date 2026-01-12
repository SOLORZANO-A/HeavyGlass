<?php

namespace App\Http\Controllers;

use App\Models\Proforma;
use App\Models\ProformaDetail;
use App\Models\WorkOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;


class ProformaController extends Controller
{
    public function index()
    {
        $proformas = Proforma::with([
            'workOrder.intakeSheet.vehicle'
        ])
            ->latest()
            ->paginate(10);

        return view('proformas.index', compact('proformas'));
    }

    public function create()
    {
        $workOrders = WorkOrder::with([
            'intakeSheet.vehicle'
        ])
            ->whereDoesntHave('proforma') // 🔥 CLAVE
            ->latest()
            ->get();


        return view('proformas.create', compact('workOrders'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'work_order_id' => [
                'required',
                'exists:work_orders,id',
                Rule::unique('proformas', 'work_order_id')
            ],
            'observations'            => 'nullable|string',

            'details'                 => 'required|array|min:1',
            'details.*.description'   => 'required|string',
            'details.*.price'         => 'required|numeric|min:0',
            'details.*.quantity'      => 'required|integer|min:1',
        ]);

        // 🔗 Cargar relaciones reales
        $workOrder = WorkOrder::with([
            'intakeSheet.vehicle.client'
        ])->findOrFail($data['work_order_id']);

        $vehicle = $workOrder->intakeSheet->vehicle;
        $client  = $vehicle->client;

        // 🔢 Calcular totales
        $itemsSubtotal = collect($data['details'])->sum(
            fn($item) => ($item['price'] ?? 0) * ($item['quantity'] ?? 1)
        );

        $laborSubtotal = collect($request->labor ?? [])->sum(
            fn($item) => ($item['price'] ?? 0) * ($item['quantity'] ?? 1)
        );

        $subtotal = $itemsSubtotal + $laborSubtotal;
        $tax      = round($subtotal * 0.15, 2);
        $total    = round($subtotal + $tax, 2);


        // 🧾 Crear proforma (NO firmada todavía)
        $proforma = Proforma::create([
            'work_order_id'   => $workOrder->id,

            // CLIENTE
            'client_name'     => $client->fullName(),
            'client_document' => $client->document,
            'client_phone'    => $client->phone,
            'client_email'    => $client->email,

            // VEHÍCULO
            'vehicle_brand'   => $vehicle->brand,
            'vehicle_model'   => $vehicle->model,
            'vehicle_plate'   => $vehicle->plate,

            // TOTALES
            'subtotal'        => $subtotal,
            'tax'             => $tax,
            'total'           => $total,

            'observations'    => $data['observations'] ?? null,

            // ESTADOS
            'status'           => 'pending',      // pagos
            'signature_status' => 'unsigned',     // firma
        ]);

        // 📦 Guardar detalles
        foreach ($data['details'] as $detail) {
            $proforma->details()->create([
                'item_description' => $detail['description'],
                'quantity'         => $detail['quantity'],
                'unit_price'       => $detail['price'],
                'line_total'       => $detail['price'] * $detail['quantity'],
                'type'             => 'part',
            ]);
        }

        // MANO DE OBRA
        if ($request->has('labor')) {
            foreach ($request->labor as $item) {
                $proforma->details()->create([
                    'item_description' => $item['description'],
                    'quantity'         => $item['quantity'] ?? 1,
                    'unit_price'       => $item['price'] ?? 0,
                    'line_total'       => ($item['price'] ?? 0) * ($item['quantity'] ?? 1),
                    'type'             => 'labor',
                ]);
            }
        }



        return redirect()
            ->route('proformas.show', $proforma)
            ->with('success', 'Proforma creada correctamente. Pendiente de firma.');
    }

    public function show(Proforma $proforma)
    {
        $proforma->load([
            'details',
            'workOrder.intakeSheet.vehicle.client',
        ]);

        return view('proformas.show', compact('proforma'));
    }

    public function edit(Proforma $proforma)
    {
        // 🔒 NO permitir editar si está firmada
        if ($proforma->isSigned()) {
            abort(403, 'No se puede modificar una proforma firmada.');
        }

        $proforma->load('details');

        return view('proformas.edit', compact('proforma'));
    }

    public function update(Request $request, Proforma $proforma)
    {
        // 🔒 NO permitir editar si está firmada
        if ($proforma->isSigned()) {
            abort(403, 'No se puede modificar una proforma firmada.');
        }

        $data = $request->validate([
            'observations'            => 'nullable|string',

            'details'                 => 'required|array|min:1',
            'details.*.description'   => 'required|string',
            'details.*.price'         => 'required|numeric|min:0',
            'details.*.quantity'      => 'required|integer|min:1',
        ]);

        // 🔢 Recalcular totales
        $subtotal = collect($data['details'])->sum(
            fn($item) =>
            $item['price'] * $item['quantity']
        );

        $tax   = round($subtotal * 0.15, 2);
        $total = round($subtotal + $tax, 2);

        $proforma->update([
            'observations' => $data['observations'] ?? null,
            'subtotal'     => $subtotal,
            'tax'          => $tax,
            'total'        => $total,
        ]);

        // 🔄 Reemplazar detalles
        $proforma->details()->delete();

        foreach ($data['details'] as $detail) {
            ProformaDetail::create([
                'proforma_id'      => $proforma->id,
                'item_description' => $detail['description'],
                'unit_price'       => $detail['price'],
                'quantity'         => $detail['quantity'],
                'line_total'       => $detail['price'] * $detail['quantity'],
            ]);
        }

        return redirect()
            ->route('proformas.show', $proforma)
            ->with('success', 'Proforma actualizada correctamente');
    }

    public function destroy(Proforma $proforma)
    {
        //  No eliminar si tiene pagos válidos
        if ($proforma->payments()->where('status', 'valid')->exists()) {
            return back()->withErrors(
                'No se puede eliminar una proforma con pagos registrados.'
            );
        }

        // No eliminar si está firmada
        if ($proforma->isSigned()) {
            return back()->withErrors(
                'No se puede eliminar una proforma firmada por el cliente.'
            );
        }

        $proforma->delete();

        return redirect()
            ->route('proformas.index')
            ->with('success', 'Proforma eliminada correctamente');
    }

    public function sign(Request $request, Proforma $proforma)
    {
        // 🔒 Evitar doble firma
        if ($proforma->isSigned()) {
            return back()->withErrors('Esta proforma ya fue firmada.');
        }

        $request->validate([
            'signature' => 'required|string'
        ]);

        // 🖊️ Procesar imagen base64
        $image = str_replace('data:image/png;base64,', '', $request->signature);
        $image = base64_decode($image);

        $fileName = 'signatures/proforma_' . $proforma->id . '.png';

        Storage::disk('public')->put($fileName, $image);

        $proforma->update([
            'signature_status' => 'signed',
            'signature_path'   => $fileName,
            'signed_at'        => now(),
        ]);

        return back()->with('success', 'Proforma firmada correctamente');
    }

    public function inspectionData(WorkOrder $workOrder)
    {
        $inspection = $workOrder
            ->intakeSheet
            ->inspection;

        if (!$inspection) {
            return response()->json([]);
        }

        $items = $inspection->items
            ->where(function ($q) {
                return $q->change
                    || $q->paint
                    || $q->fiber
                    || $q->dent
                    || $q->crack;
            })
            ->map(function ($item) {

                $actions = [];

                if ($item->change) $actions[] = 'Cambio';
                if ($item->paint)  $actions[] = 'Pintura';
                if ($item->fiber)  $actions[] = 'Fibra';
                if ($item->dent)   $actions[] = 'Enderezado';
                if ($item->crack)  $actions[] = 'Fisura';

                return [
                    'description' =>
                    $item->part->name . ' (' . implode(', ', $actions) . ')'
                ];
            })
            ->values();

        return response()->json($items);
    }
}
