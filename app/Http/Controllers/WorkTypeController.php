<?php

namespace App\Http\Controllers;

use App\Models\WorkType;
use Illuminate\Http\Request;

class WorkTypeController extends Controller
{
    public function index()
    {
        $workTypes = WorkType::orderBy('name')->paginate(10);
        return view('work_types.index', compact('workTypes'));
    }

    public function create()
    {
        return view('work_types.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:work_types,name',
            'description' => 'nullable|string',
        ]);

        WorkType::create($data);

        return redirect()
            ->route('work_types.index')
            ->with('success', 'Work type created successfully');
    }

    public function show(WorkType $workType)
    {
        return view('work_types.show', compact('workType'));
    }

    public function edit(WorkType $workType)
    {
        return view('work_types.edit', compact('workType'));
    }

    public function update(Request $request, WorkType $workType)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:work_types,name,' . $workType->id,
            'description' => 'nullable|string',
        ]);

        $workType->update($data);

        return redirect()
            ->route('work_types.index')
            ->with('success', 'Work type updated successfully');
    }

    public function destroy(WorkType $workType)
    {
        $workType->delete();

        return redirect()
            ->route('work_types.index')
            ->with('success', 'Work type deleted successfully');
    }
}
