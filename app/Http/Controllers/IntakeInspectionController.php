<?php

namespace App\Http\Controllers;

use App\Models\IntakeInspection;
use App\Models\IntakeInspectionItem;
use App\Models\IntakeInspectionPhoto;
use App\Models\InspectionZone;
use App\Models\IntakeSheet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IntakeInspectionController extends Controller
{
    public function create(IntakeSheet $intakeSheet)
    {
        // Evitar doble inspección
        if ($intakeSheet->inspection) {
            return redirect()
                ->back()
                ->with('error', 'Esta hoja de ingreso ya tiene una inspección registrada');
        }

        $zones = InspectionZone::with('parts')->get();

        return view('intake_sheets.inspection', compact(
            'intakeSheet',
            'zones'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'intake_sheet_id' => 'required|exists:intake_sheets,id',
            'items'           => 'nullable|array',
            'photos'          => 'nullable|array',
            'observations'    => 'nullable|array',
        ]);

        DB::transaction(function () use ($request) {

            /*
            |------------------------------------------------------------
            | 1️⃣ Crear inspección principal
            |------------------------------------------------------------
            */
            $inspection = IntakeInspection::create([
                'intake_sheet_id' => $request->intake_sheet_id,
                'created_by'      => auth()->id(),

            ]);

            /*
            |------------------------------------------------------------
            | 2️⃣ Guardar checklist por zona y pieza
            |------------------------------------------------------------
            */
            if ($request->has('items')) {
                foreach ($request->items as $zoneId => $parts) {
                    foreach ($parts as $partId => $actions) {

                        IntakeInspectionItem::create([
                            'intake_inspection_id' => $inspection->id,
                            'inspection_zone_id'   => $zoneId,
                            'inspection_part_id'   => $partId,
                            'change'               => array_key_exists('change', $actions),
                            'paint'                => array_key_exists('paint', $actions),
                            'fiber'                => array_key_exists('fiber', $actions),
                            'dent'                 => array_key_exists('dent', $actions),
                            'crack'                => array_key_exists('crack', $actions),
                            'notes'  => $request->observations[$zoneId] ?? null,
                        ]);
                    }
                }
            }

            /*
            |------------------------------------------------------------
            | 3️⃣ Guardar fotos por zona
            |------------------------------------------------------------
            */
            if ($request->has('photos')) {
                foreach ($request->file('photos', []) as $zoneId => $files) {
                    foreach ($files as $file) {

                        if (!$file || !$file->isValid()) {
                            continue;
                        }

                        $path = $file->store(
                            'inspection_photos/' . $inspection->id . '/' . $zoneId,
                            'public'
                        );

                        IntakeInspectionPhoto::create([
                            'intake_inspection_id' => $inspection->id,
                            'inspection_zone_id'   => $zoneId,
                            'path'                 => $path,
                        ]);
                    }
                }
            }
        });

        return redirect()
            ->route('intake_sheets.index')
            ->with('success', 'Inspección vehicular registrada correctamente');
    }
}
