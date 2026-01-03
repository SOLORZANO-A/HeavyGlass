<?php

namespace App\Http\Controllers;

use App\Models\IntakePhoto;
use App\Models\IntakeSheet;
use App\Models\Vehicle;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB as FacadesDB;
use Illuminate\Support\Facades\DB;


class IntakeSheetController extends Controller
{
    public function index()
    {
        $intakeSheets = IntakeSheet::with('vehicle.client')
            ->latest()
            ->paginate(10);

        return view('intake_sheets.index', compact('intakeSheets'));
    }

    public function create()
    {
        $vehicles = Vehicle::with('client')->get();

        return view('intake_sheets.create', compact('vehicles'));
    }

    public function store(Request $request)
{
    $data = $request->validate([
        'vehicle_id'    => 'required|exists:vehicles,id',
        'entry_at'      => 'nullable|date',
        'km_at_entry'   => 'nullable|integer|min:0',
        'fuel_level'    => 'nullable|string|max:10',

        'has_dents'     => 'nullable',
        'has_scratches' => 'nullable',
        'has_cracks'    => 'nullable',

        'valuables'     => 'nullable|string',
        'observations'  => 'nullable|string',

        // 👇 VALIDACIÓN CORRECTA PARA MÚLTIPLES FOTOS
        'photos'        => 'nullable|array',
        'photos.*'      => 'image|mimes:jpg,jpeg,png|max:4096',
    ]);

    FacadesDB::beginTransaction();

    try {

        // ✅ 1. CREAR HOJA DE INGRESO
        $intakeSheet = IntakeSheet::create([
            'vehicle_id'    => $data['vehicle_id'],
            'advisor_id'    => auth()->id(),
            'entry_at'      => $data['entry_at'] ?? now(),
            'km_at_entry'   => $data['km_at_entry'] ?? null,
            'fuel_level'    => $data['fuel_level'] ?? null,

            // ✔️ CHECKBOX SEGUROS
            'has_dents'     => $request->boolean('has_dents'),
            'has_scratches' => $request->boolean('has_scratches'),
            'has_cracks'    => $request->boolean('has_cracks'),

            'valuables'     => $data['valuables'] ?? null,
            'observations'  => $data['observations'] ?? null,
        ]);

        // ✅ 2. GUARDAR FOTOS (ARCHIVO O CÁMARA)
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photo) {

                $path = $photo->store('intake_photos', 'public');

                $intakeSheet->photos()->create([
                    'path' => $path,
                ]);
            }
        }

        DB::commit();

        return redirect()
            ->route('intake_sheets.show', $intakeSheet)
            ->with('success', 'Hoja de ingreso creada correctamente');

    } catch (\Exception $e) {

        DB::rollBack();

        return back()
            ->withErrors('Ocurrió un error al guardar la hoja de ingreso.')
            ->withInput();
    }
}


    public function show(IntakeSheet $intakeSheet)
    {
        $intakeSheet->load('vehicle.client', 'photos');

        return view('intake_sheets.show', compact('intakeSheet'));
    }

    public function edit(IntakeSheet $intakeSheet)
    {
        return view('intake_sheets.edit', compact('intakeSheet'));
    }

    public function update(Request $request, IntakeSheet $intakeSheet)
    {
        $data = $request->validate([
            'entry_at'      => 'nullable|date',
            'km_at_entry'   => 'nullable|integer|min:0',
            'fuel_level'    => 'nullable|string|max:10',

            'valuables'     => 'nullable|string',
            'observations'  => 'nullable|string',

            'photos.*'      => 'image|max:4096',
        ]);

        $intakeSheet->update([
            'entry_at'      => $data['entry_at'] ?? $intakeSheet->entry_at,
            'km_at_entry'   => $data['km_at_entry'] ?? $intakeSheet->km_at_entry,
            'fuel_level'    => $data['fuel_level'] ?? $intakeSheet->fuel_level,

            'has_dents'     => $request->boolean('has_dents'),
            'has_scratches' => $request->boolean('has_scratches'),
            'has_cracks'    => $request->boolean('has_cracks'),

            'valuables'     => $data['valuables'] ?? $intakeSheet->valuables,
            'observations'  => $data['observations'] ?? $intakeSheet->observations,
        ]);

        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photo) {
                $intakeSheet->photos()->create([
                    'path' => $photo->store('intake_photos', 'public'),
                ]);
            }
        }

        return redirect()
            ->route('intake_sheets.show', $intakeSheet)
            ->with('success', 'Hoja actualizada correctamente');
    }



    public function destroy(IntakeSheet $intakeSheet)
    {
        // 🔒 1. PROTEGER: no eliminar si tiene órdenes de trabajo
        if ($intakeSheet->workOrders()->exists()) {
            return redirect()
                ->route('intake_sheets.index')
                ->with('error', 'No se puede eliminar la hoja de ingreso porque tiene órdenes de trabajo asociadas.');
        }

        // 🧹 2. ELIMINAR FOTOS (archivo + BD)
        foreach ($intakeSheet->photos as $photo) {

            // borrar archivo físico
            if (Storage::disk('public')->exists($photo->path)) {
                Storage::disk('public')->delete($photo->path);
            }

            // borrar registro de la foto
            $photo->delete();
        }

        // 🗑️ 3. ELIMINAR LA HOJA
        $intakeSheet->delete();

        return redirect()
            ->route('intake_sheets.index')
            ->with('success', 'Hoja de ingreso eliminada correctamente');
    }


    public function destroyPhoto(IntakePhoto $photo)
    {
        if (Storage::disk('public')->exists($photo->path)) {
            Storage::disk('public')->delete($photo->path);
        }

        $photo->delete();

        return back()->with('success', 'Foto eliminada correctamente');
    }
}
