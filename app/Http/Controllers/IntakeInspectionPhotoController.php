<?php

namespace App\Http\Controllers;

use App\Models\IntakeInspectionPhoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class IntakeInspectionPhotoController extends Controller
{
    /**
     * Subir fotos por zona
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'intake_inspection_id' => 'required|exists:intake_inspections,id',
            'inspection_zone_id'   => 'required|exists:inspection_zones,id',
            'photos.*'             => 'required|image|max:4096',
        ]);

        foreach ($request->file('photos') as $photo) {
            $path = $photo->store('intake_inspections', 'public');

            IntakeInspectionPhoto::create([
                'intake_inspection_id' => $data['intake_inspection_id'],
                'inspection_zone_id'   => $data['inspection_zone_id'],
                'path'                 => $path,
            ]);
        }

        return response()->json([
            'success' => true
        ]);
    }
}

