<?php

namespace App\Http\Controllers;

use App\Models\WorkOrder;
use App\Models\WorkType;
use App\Models\Profile;
use App\Models\IntakeSheet;
use Illuminate\Http\Request;

class WorkOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $workOrders = WorkOrder::with([
            'intakeSheet.vehicle',
            'workTypes',
            'technicians',
        ])
            ->latest()
            ->paginate(10);


        return view('work_orders.index', compact('workOrders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $intakeSheets = IntakeSheet::with(['vehicle'])
            ->whereDoesntHave('workOrders') // 👈 EXCLUIR las que ya tienen OT
            ->orderBy('created_at', 'desc')
            ->get();

        $workTypes = WorkType::orderBy('name')->get();
        $technicians = Profile::whereIn(
            'specialization',
            Profile::TECHNICAL_SPECIALTIES
        )->orderBy('first_name')->get();

        return view(
            'work_orders.create',
            compact('intakeSheets', 'workTypes', 'technicians')
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'intake_sheet_id' => 'required|exists:intake_sheets,id',

            'work_type_ids'   => 'required|array|min:1',
            'work_type_ids.*' => 'exists:work_types,id',

            'technicians'     => 'required|array|min:1',
            'technicians.*'   => 'exists:profiles,id',
            'started_at'      => 'nullable|date', // ✅ CLAVE
            'status'          => 'required|in:pending,in_progress,paused,completed',
            'description'     => 'nullable|string',
        ]);

        $status = $data['status'];

        // 🧠 Si viene fecha de inicio y sigue en pending → pasar a in_progress
        if (!empty($data['started_at']) && $status === 'pending') {
            $status = 'in_progress';
        }

        $workOrder = WorkOrder::create([
            'intake_sheet_id' => $data['intake_sheet_id'],
            'status'          => $status,
            'description'     => $data['description'] ?? null,
            'assigned_at'     => now(),
            'started_at'      => $data['started_at'] ?? null,
            'finished_at'     => $status === 'completed' ? now() : null,
        ]);


        // relaciones
        $workOrder->workTypes()->sync($data['work_type_ids']);
        $workOrder->technicians()->sync($data['technicians']);

        return redirect()
            ->route('work_orders.index')
            ->with('success', 'Orden de trabajo creada correctamente');
    }



    /**
     * Display the specified resource.
     */
    public function show(WorkOrder $workOrder)
    {
        $workOrder->load([
            'intakeSheet.vehicle',
            'workTypes',
            'technicians',
        ]);


        return view('work_orders.show', compact('workOrder'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(WorkOrder $workOrder)
    {
        $intakeSheets = IntakeSheet::with('vehicle')->latest()->get();
        $workTypes = WorkType::orderBy('name')->get();
        $technicians = Profile::where('staff_type', 'technician')
            ->orderBy('first_name')
            ->get();

        return view(
            'work_orders.edit',
            compact('workOrder', 'intakeSheets', 'workTypes', 'technicians')
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, WorkOrder $workOrder)
    {
        $data = $request->validate([
            'intake_sheet_id' => 'required|exists:intake_sheets,id',

            'work_type_ids'   => 'required|array|min:1',
            'work_type_ids.*' => 'exists:work_types,id',

            'technicians'     => 'required|array|min:1',
            'technicians.*'   => 'exists:profiles,id',

            'status'          => 'required|in:pending,in_progress,paused,completed',
            'started_at'      => 'nullable|date',
            'description'     => 'nullable|string',
        ]);

        /* ===================== FECHAS ===================== */

        // Fecha de inicio manual
        if (!empty($data['started_at'])) {
            $workOrder->started_at = $data['started_at'];
        }

        // Fecha de finalización automática
        if ($data['status'] === 'completed' && !$workOrder->finished_at) {
            $workOrder->finished_at = now();
        }

        /* ===================== UPDATE ===================== */

        $workOrder->update([
            'intake_sheet_id' => $data['intake_sheet_id'],
            'status'          => $data['status'],
            'description'     => $data['description'] ?? null,
        ]);

        /* ===================== RELACIONES ===================== */

        // Tipos de trabajo
        $workOrder->workTypes()->sync($data['work_type_ids']);

        // Técnicos (TABLA PIVOTE)
        $workOrder->technicians()->sync($data['technicians']);

        return redirect()
            ->route('work_orders.index')
            ->with('success', 'Orden de trabajo actualizada correctamente');
    }




    /**
     * Remove the specified resource from storage.
     */
    public function destroy(WorkOrder $workOrder)
    {
        $workOrder->delete();

        return redirect()
            ->route('work_orders.index')
            ->with('success', 'Work Order deleted successfully');
    }
}
