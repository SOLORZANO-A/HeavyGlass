<?php

namespace App\Http\Controllers;

use App\Models\IntakeInspectionItem;
use Illuminate\Http\Request;

class IntakeInspectionItemController extends Controller
{
    /**
     * Guardar o actualizar checklist de una pieza
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'intake_inspection_id' => 'required|exists:intake_inspections,id',
            'inspection_zone_id'   => 'required|exists:inspection_zones,id',
            'inspection_part_id'   => 'required|exists:inspection_parts,id',
            'damages'              => 'required|array',
            'notes'                => 'nullable|string',
        ]);

        $item = IntakeInspectionItem::updateOrCreate(
            [
                'intake_inspection_id' => $data['intake_inspection_id'],
                'inspection_part_id'   => $data['inspection_part_id'],
            ],
            [
                'inspection_zone_id' => $data['inspection_zone_id'],
                'damages'            => $data['damages'],
                'notes'              => $data['notes'] ?? null,
            ]
        );

        return response()->json([
            'success' => true,
            'item_id' => $item->id
        ]);
    }
}

