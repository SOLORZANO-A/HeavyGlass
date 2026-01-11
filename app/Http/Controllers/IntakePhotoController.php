<?php

namespace App\Http\Controllers;

use App\Models\IntakePhoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class IntakePhotoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */


    public function destroy(IntakePhoto $intakePhoto)
    {
        // ❌ NO BORRAR intakeSheet
        // ❌ NO usar $intakePhoto->intakeSheet()->delete()

        // 🧹 eliminar archivo
        if ($intakePhoto->path && Storage::disk('public')->exists($intakePhoto->path)) {
            Storage::disk('public')->delete($intakePhoto->path);
        }

        // ✅ eliminar SOLO la foto
        $intakePhoto->delete();

        return back()->with('success', 'Foto eliminada correctamente');
    }


}
