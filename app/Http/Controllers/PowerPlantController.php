<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PowerPlant;
use App\Models\PowerPlantType;
use App\Models\Organization;
use App\Models\RegType;

class PowerPlantController extends Controller
{
    public function index()
    {
        $plants = PowerPlant::with(['type', 'organization', 'regType'])->get();
        return view('power_plants.index', compact('plants'));
    }

    public function create()
    {
        $types    = PowerPlantType::all();
        $orgs     = Organization::orderBy('org_name')->get();
        $regTypes = RegType::orderBy('type_name')->get();
        return view('power_plants.create', compact('types', 'orgs', 'regTypes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'plant_name'  => 'required|string|max:255',
            'type_id'     => 'required|exists:power_plant_types,id',
            'org_id'      => 'nullable|exists:organizations,id',
            'reg_type_id' => 'nullable|exists:reg_types,id',
        ]);

        PowerPlant::create($request->only('plant_name', 'type_id', 'org_id', 'reg_type_id'));

        return redirect()->route('power_plants.index')->with('success', 'Станц бүртгэгдлээ.');
    }

    public function edit(PowerPlant $power_plant)
    {
        $types    = PowerPlantType::all();
        $orgs     = Organization::orderBy('org_name')->get();
        $regTypes = RegType::orderBy('type_name')->get();
        return view('power_plants.edit', compact('power_plant', 'types', 'orgs', 'regTypes'));
    }

    public function update(Request $request, PowerPlant $power_plant)
    {
        $request->validate([
            'plant_name'  => 'required|string|max:255',
            'type_id'     => 'required|exists:power_plant_types,id',
            'org_id'      => 'nullable|exists:organizations,id',
            'reg_type_id' => 'nullable|exists:reg_types,id',
        ]);

        $power_plant->update($request->only('plant_name', 'type_id', 'org_id', 'reg_type_id'));

        return redirect()->route('power_plants.index')->with('success', 'Станц шинэчлэгдлээ.');
    }

    public function destroy(PowerPlant $power_plant)
    {
        $power_plant->delete();
        return redirect()->route('power_plants.index')->with('success', 'Станц устгагдлаа.');
    }
}