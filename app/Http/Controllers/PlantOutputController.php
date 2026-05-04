<?php

namespace App\Http\Controllers;

use App\Models\PlantOutput;
use App\Models\PowerPlant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Exports\PlantOutputExport;
use Maatwebsite\Excel\Facades\Excel;

class PlantOutputController extends Controller
{
    public function index(Request $request)
    {
        $user        = Auth::user();
        $year        = $request->input('year');
        $month       = $request->input('month');
        $productType = $request->input('product_type');

        $query = PlantOutput::with(['powerPlant', 'organization']);

        if ($user?->role?->name !== 'admin') {
            $query->where('org_id', $user->org_id);
        }
        if ($user?->role?->name === 'admin') {
            $query->join('organizations', 'plant_output.org_id', '=', 'organizations.id')
                  ->orderBy('organizations.org_code')
                  ->select('plant_output.*');
        }
        if ($year)        $query->where('year', $year);
        if ($month)       $query->where('month', $month);
        if ($productType) $query->where('product_name', 'like', '%' . $productType . '%');

        if ($request->input('export') === 'excel') {
            $filename = 'plant_output_' . ($year ?: 'all') . '_' . ($month ?: 'all') . '.xlsx';
            return Excel::download(
                new PlantOutputExport($year, $month, $user?->role?->name !== 'admin' ? $user?->org_id : null),
                $filename
            );
        }

        $outputs = $query->get();
        return view('plant_output.index', compact('outputs', 'year', 'month', 'productType'));
    }

    public function create()
    {
        $user = Auth::user();
        if ($user->role?->name === 'admin') {
            return redirect()->route('plant_output.index')->with('error', 'Админ мэдээ нэмэх эрхгүй.');
        }
        $plants = PowerPlant::with('regType')->where('org_id', $user->org_id)->orderBy('plant_name')->get();
        return view('plant_output.create', compact('plants'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        if ($user->role?->name === 'admin') {
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
        if (!$plant || $plant->org_id !== $user->org_id) {
            return redirect()->back()->with('error', 'Зөвшөөрөлгүй үйлдэл.');
        }
        $data           = $request->all();
        $data['org_id'] = $plant->org_id;

        PlantOutput::create($data);
        return redirect()->route('plant_output.index')->with('success', 'Амжилттай нэмэгдлээ.');
    }

    public function edit(PlantOutput $plant_output)
    {
        $user = Auth::user();
        if ($user->role?->name === 'admin') {
            return redirect()->route('plant_output.index')->with('error', 'Админ мэдээ засах эрхгүй.');
        }
        if ($plant_output->org_id !== $user->org_id) {
            return redirect()->route('plant_output.index')->with('error', 'Зөвшөөрөлгүй үйлдэл.');
        }
        $plants = PowerPlant::with('regType')->where('org_id', $user->org_id)->orderBy('plant_name')->get();
        return view('plant_output.edit', compact('plant_output', 'plants'));
    }

    public function update(Request $request, PlantOutput $plant_output)
    {
        $user = Auth::user();
        if ($user->role?->name === 'admin') {
            return redirect()->route('plant_output.index')->with('error', 'Админ мэдээ засах эрхгүй.');
        }
        if ($plant_output->org_id !== $user->org_id) {
            return redirect()->route('plant_output.index')->with('error', 'Зөвшөөрөлгүй үйлдэл.');
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
        if (!$plant || $plant->org_id !== $user->org_id) {
            return redirect()->back()->with('error', 'Зөвшөөрөлгүй үйлдэл.');
        }
        $data           = $request->all();
        $data['org_id'] = $plant->org_id;

        $plant_output->update($data);
        return redirect()->route('plant_output.index')->with('success', 'Амжилттай шинэчлэгдлээ.');
    }

    public function destroy(PlantOutput $plant_output)
    {
        $user = Auth::user();
        if ($user->role?->name === 'admin') {
            return redirect()->route('plant_output.index')->with('error', 'Админ мэдээ устгах эрхгүй.');
        }
        if ($plant_output->org_id !== $user->org_id) {
            return redirect()->route('plant_output.index')->with('error', 'Зөвшөөрөлгүй үйлдэл.');
        }
        $plant_output->delete();
        return redirect()->route('plant_output.index')->with('success', 'Амжилттай устгалаа.');
    }
}
