<?php

namespace App\Http\Controllers;

use App\Models\PlantOutput;
use App\Models\PowerPlant;
use App\Models\RegType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Exports\PlantOutputExport;
use Maatwebsite\Excel\Facades\Excel;

class PlantOutputController extends Controller
{
    public function index(Request $request)
    {
        $user       = Auth::user();
        $year       = $request->input('year');
        $month      = $request->input('month');
        $regTypeId  = $request->input('reg_type_id');

        $query = PlantOutput::with(['powerPlant.regType', 'organization']);

        if ($user?->role?->name !== 'admin' && $user?->org_id) {
            $query->whereHas('powerPlant', fn($q) => $q->where('org_id', $user->org_id));
        }
        if ($regTypeId) {
            $query->whereHas('powerPlant', fn($q) => $q->where('reg_type_id', $regTypeId));
        }
        if ($year)  $query->where('year', $year);
        if ($month) $query->where('month', $month);

        if ($request->input('export') === 'excel') {
            $filename = 'plant_output_' . ($year ?: 'all') . '_' . ($month ?: 'all') . '.xlsx';
            return Excel::download(
                new PlantOutputExport($year, $month, $user?->role?->name !== 'admin' ? $user?->org_id : null),
                $filename
            );
        }

        $regTypes = RegType::orderBy('type_name')->get();
        $outputs  = $query->get();
        return view('plant_output.index', compact('outputs', 'year', 'month', 'regTypes', 'regTypeId'));
    }

    public function create()
    {
        $user = Auth::user();
        if ($user->role?->name === 'admin') {
            return redirect()->route('plant_output.index')->with('error', 'Админ мэдээ нэмэх эрхгүй.');
        }
        $plants   = PowerPlant::with('regType')->where('org_id', $user->org_id)->orderBy('plant_name')->get();
        $regTypes = RegType::orderBy('type_name')->get();
        return view('plant_output.create', compact('plants', 'regTypes'));
    }

    public function store(Request $request)
    {
        if (Auth::user()->role?->name === 'admin') {
            return redirect()->route('plant_output.index')->with('error', 'Админ мэдээ нэмэх эрхгүй.');
        }
        $request->validate([
            'power_plant_id' => 'required|exists:power_plants,id',
            'year'           => 'required|integer|min:2000|max:2100',
            'month'          => 'required|integer|min:1|max:12',
            'product_name'   => 'required|string',
            'unit_name'      => 'required|string',
            'before_month'   => 'required|numeric|min:0',
            'this_month'     => 'required|numeric|min:0',
            'year_usage'     => 'required|numeric|min:0',
            'this_musage'    => 'required|numeric|min:0',
        ]);

        $plant = PowerPlant::find($request->power_plant_id);
        $data  = $request->all();
        $data['org_id'] = $plant?->org_id;

        PlantOutput::create($data);
        return redirect()->route('plant_output.index')->with('success', 'Амжилттай нэмэгдлээ.');
    }

    public function edit(PlantOutput $plant_output)
    {
        if (Auth::user()->role?->name === 'admin') {
            return redirect()->route('plant_output.index')->with('error', 'Админ мэдээ засах эрхгүй.');
        }
        $user     = Auth::user();
        $plants   = PowerPlant::with('regType')->where('org_id', $user->org_id)->orderBy('plant_name')->get();
        $regTypes = RegType::orderBy('type_name')->get();
        return view('plant_output.edit', compact('plant_output', 'plants', 'regTypes'));
    }

    public function update(Request $request, PlantOutput $plant_output)
    {
        if (Auth::user()->role?->name === 'admin') {
            return redirect()->route('plant_output.index')->with('error', 'Админ мэдээ засах эрхгүй.');
        }
        $request->validate([
            'power_plant_id' => 'required|exists:power_plants,id',
            'year'           => 'required|integer|min:2000|max:2100',
            'month'          => 'required|integer|min:1|max:12',
            'product_name'   => 'required|string',
            'unit_name'      => 'required|string',
            'before_month'   => 'required|numeric|min:0',
            'this_month'     => 'required|numeric|min:0',
            'year_usage'     => 'required|numeric|min:0',
            'this_musage'    => 'required|numeric|min:0',
        ]);

        $plant = PowerPlant::find($request->power_plant_id);
        $data  = $request->all();
        $data['org_id'] = $plant?->org_id;

        $plant_output->update($data);
        return redirect()->route('plant_output.index')->with('success', 'Амжилттай шинэчлэгдлээ.');
    }

    public function destroy(PlantOutput $plant_output)
    {
        if (Auth::user()->role?->name === 'admin') {
            return redirect()->route('plant_output.index')->with('error', 'Админ мэдээ устгах эрхгүй.');
        }
        $plant_output->delete();
        return redirect()->route('plant_output.index')->with('success', 'Амжилттай устгалаа.');
    }
}
