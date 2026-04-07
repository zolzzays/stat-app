<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\PowerPlantType;
use Illuminate\Http\Request;

class PowerPlantTypeController extends Controller
{
    // LIST
    public function index()
    {
        $data = PowerPlantType::latest()->get();
        return view('power_plant_type.index', compact('data'));
    }

    // CREATE FORM
    public function create()
    {
        return view('power_plant_type.create');
    }

    // STORE
    public function store(Request $request)
    {
        $request->validate([
            't_name' => 'required'
        ]);

        PowerPlantType::create($request->all());

        return redirect()->route('powerplant.index')
            ->with('success', 'Амжилттай нэмэгдлээ');
    }

    // EDIT FORM
    public function edit($id)
    {
        $item = PowerPlantType::findOrFail($id);
        return view('power_plant_type.edit', compact('item'));
    }

    // UPDATE
    public function update(Request $request, $id)
    {
        $request->validate([
            't_name' => 'required'
        ]);

        $item = PowerPlantType::findOrFail($id);
        $item->update($request->all());

        return redirect()->route('powerplant.index')
            ->with('success', 'Амжилттай засагдлаа');
    }

    // DELETE
    public function destroy($id)
    {
        PowerPlantType::findOrFail($id)->delete();

        return redirect()->back()
            ->with('success', 'Устгагдлаа');
    }
}