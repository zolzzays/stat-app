<?php

namespace App\Http\Controllers;

use App\Models\EnergySale;
use App\Models\PowerPlant;
use App\Models\RegType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Exports\EnergySalesExport;
use Maatwebsite\Excel\Facades\Excel;

class EnergySalesController extends Controller
{
    public function index(Request $request)
    {
        $user        = Auth::user();
        $year        = $request->input('year');
        $month       = $request->input('month');
        $regTypeId   = $request->input('reg_type_id');
        $productType = $request->input('product_type');

        $query = EnergySale::with(['powerPlant.regType', 'organization']);

        if ($user?->role?->name !== 'admin' && $user?->org_id) {
            $query->whereHas('powerPlant', fn($q) => $q->where('org_id', $user->org_id));
        }
        if ($regTypeId) {
            $query->whereHas('powerPlant', fn($q) => $q->where('reg_type_id', $regTypeId));
        }
        if ($year)        $query->where('year', $year);
        if ($month)       $query->where('month', $month);
        if ($productType) $query->where('product_name', 'like', '%' . $productType . '%');

        if ($request->input('export') === 'excel') {
            $filename = 'energy_sales_' . ($year ?: 'all') . '_' . ($month ?: 'all') . '.xlsx';
            return Excel::download(
                new EnergySalesExport($year, $month, $user->role?->name !== 'admin' ? $user->org_id : null),
                $filename
            );
        }

        $regTypes = RegType::orderBy('type_name')->get();
        $sales    = $query->get();
        return view('energy_sales.index', compact('sales', 'year', 'month', 'regTypes', 'regTypeId', 'productType'));
    }

    public function create()
    {
        $user = Auth::user();

        if ($user->role?->name === 'admin') {
            return redirect()->route('energy_sales.index')->with('error', 'Админ мэдээ нэмэх эрхгүй.');
        }

        $plants   = PowerPlant::with('regType')->where('org_id', $user->org_id)->orderBy('plant_name')->get();
        $regTypes = RegType::orderBy('type_name')->get();
        return view('energy_sales.create', compact('plants', 'regTypes'));
    }

    public function store(Request $request)
    {
        if (Auth::user()->role?->name === 'admin') {
            return redirect()->route('energy_sales.index')->with('error', 'Админ мэдээ нэмэх эрхгүй.');
        }
        $request->validate([
            'power_plant_id' => 'required|exists:power_plants,id',
            'year'           => 'required|integer|min:2000|max:2100',
            'month'          => 'required|integer|min:1|max:12',
            'product_name'   => 'required|string',
            'unit_name'      => 'required|string',
            'before_month'   => 'required|numeric|min:0',
            'before_sal'     => 'required|numeric|min:0',
            'this_month'     => 'required|numeric|min:0',
            'this_sal'       => 'required|numeric|min:0',
            'year_usage'     => 'required|numeric|min:0',
            'year_sal'       => 'required|numeric|min:0',
            'this_musage'    => 'required|numeric|min:0',
            'this_msal'      => 'required|numeric|min:0',
        ]);

        $plant = PowerPlant::find($request->power_plant_id);
        $data  = $request->all();
        $data['org_id'] = $plant?->org_id;

        EnergySale::create($data);
        return redirect()->route('energy_sales.index')->with('success', 'Борлуулалтын мэдээ амжилттай нэмэгдлээ.');
    }

    public function edit(EnergySale $energy_sale)
    {
        $user = Auth::user();

        if ($user->role?->name === 'admin') {
            return redirect()->route('energy_sales.index')->with('error', 'Админ мэдээ засах эрхгүй.');
        }

        $plants   = PowerPlant::with('regType')->where('org_id', $user->org_id)->orderBy('plant_name')->get();
        $regTypes = RegType::orderBy('type_name')->get();
        return view('energy_sales.edit', compact('energy_sale', 'plants', 'regTypes'));
    }

    public function update(Request $request, EnergySale $energy_sale)
    {
        if (Auth::user()->role?->name === 'admin') {
            return redirect()->route('energy_sales.index')->with('error', 'Админ мэдээ засах эрхгүй.');
        }
        $request->validate([
            'power_plant_id' => 'required|exists:power_plants,id',
            'year'           => 'required|integer|min:2000|max:2100',
            'month'          => 'required|integer|min:1|max:12',
            'product_name'   => 'required|string',
            'unit_name'      => 'required|string',
            'before_month'   => 'required|numeric|min:0',
            'before_sal'     => 'required|numeric|min:0',
            'this_month'     => 'required|numeric|min:0',
            'this_sal'       => 'required|numeric|min:0',
            'year_usage'     => 'required|numeric|min:0',
            'year_sal'       => 'required|numeric|min:0',
            'this_musage'    => 'required|numeric|min:0',
            'this_msal'      => 'required|numeric|min:0',
        ]);

        $plant = PowerPlant::find($request->power_plant_id);
        $data  = $request->all();
        $data['org_id'] = $plant?->org_id;

        $energy_sale->update($data);
        return redirect()->route('energy_sales.index')->with('success', 'Борлуулалтын мэдээ амжилттай шинэчлэгдлээ.');
    }

    public function destroy(EnergySale $energy_sale)
    {
        if (Auth::user()->role?->name === 'admin') {
            return redirect()->route('energy_sales.index')->with('error', 'Админ мэдээ устгах эрхгүй.');
        }

        $energy_sale->delete();
        return redirect()->route('energy_sales.index')->with('success', 'Борлуулалтын мэдээ устгагдлаа.');
    }
}
