<?php

namespace App\Http\Controllers\Admin;

use App\Models\Equipment;
use App\Models\Category;
use App\Models\Location;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EquipmentController extends Controller
{
    public function index()
    {
        $equipment = Equipment::all();
        return view('admin.equipment.index', compact('equipment'));
    }

    public function create()
    {
        $categories = Category::all();
        $locations = Location::all();
        return view('admin.equipment.create', compact('categories', 'locations'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'location_id' => 'required|exists:locations,id',
            'quantity' => 'required|integer|min:1',
            'description' => 'nullable|string',
        ]);

        Equipment::create($validated);

        return redirect()->route('admin.equipment.index')->with('success', 'Equipment added successfully!');
    }

    public function edit($id)
    {
        $equipment = Equipment::findOrFail($id);
        $categories = Category::all();
        $locations = Location::all();
        return view('admin.equipment.edit', compact('equipment', 'categories', 'locations'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'location_id' => 'required|exists:locations,id',
            'quantity' => 'required|integer|min:1',
            'description' => 'nullable|string',
        ]);

        $equipment = Equipment::findOrFail($id);
        $equipment->update($validated);

        return redirect()->route('admin.equipment.index')->with('success', 'Equipment updated successfully!');
    }

    public function destroy($id)
    {
        $equipment = Equipment::findOrFail($id);
        $equipment->delete();

        return redirect()->route('admin.equipment.index')->with('success', 'Equipment deleted successfully!');
    }
}
