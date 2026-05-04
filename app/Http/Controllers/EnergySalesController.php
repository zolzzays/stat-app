<?php

namespace App\Http\Controllers;

use App\Models\EnergySale;
use App\Models\PowerPlant;
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
        $productType = $request->input('product_type');

        $query = EnergySale::with(['powerPlant', 'organization']);

        if ($user?->role?->name !== 'admin') {
            $query->where('org_id', $user->org_id);
        }
        if ($user?->role?->name === 'admin') {
            $query->join('organizations', 'energy_sales.org_id', '=', 'organizations.id')
                  ->orderBy('organizations.org_code')
                  ->select('energy_sales.*');
        }
        if ($year)        $query->where('year', $year);
        if ($month)       $query->where('month', $month);
        if ($productType) $query->where('product_name', 'like', '%' . $productType . '%');

        if ($request->input('export') === 'excel') {
            $filename = 'energy_sales_' . ($year ?: 'all') . '_' . ($month ?: 'all') . '.xlsx';
            return Excel::download(
                new EnergySalesExport($year, $month, $user?->role?->name !== 'admin' ? $user?->org_id : null),
                $filename
            );
        }

        $sales = $query->get();
        return view('energy_sales.index', compact('sales', 'year', 'month', 'productType'));
    }

    public function create()
    {
        $user = Auth::user();

        if ($user->role?->name === 'admin') {
            return redirect()->route('energy_sales.index')->with('error', 'Админ мэдээ нэмэх эрхгүй.');
        }

        $plants = PowerPlant::with('regType')->where('org_id', $user->org_id)->orderBy('plant_name')->get();
        return view('energy_sales.create', compact('plants'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        if ($user->role?->name === 'admin') {
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
        if (!$plant || $plant->org_id !== $user->org_id) {
            return redirect()->back()->with('error', 'Зөвшөөрөлгүй үйлдэл.');
        }
        $data           = $request->all();
        $data['org_id'] = $plant->org_id;

        EnergySale::create($data);
        return redirect()->route('energy_sales.index')->with('success', 'Борлуулалтын мэдээ амжилттай нэмэгдлээ.');
    }

    public function edit(EnergySale $energy_sale)
    {
        $user = Auth::user();

        if ($user->role?->name === 'admin') {
            return redirect()->route('energy_sales.index')->with('error', 'Админ мэдээ засах эрхгүй.');
        }
        if ($energy_sale->org_id !== $user->org_id) {
            return redirect()->route('energy_sales.index')->with('error', 'Зөвшөөрөлгүй үйлдэл.');
        }

        $plants = PowerPlant::with('regType')->where('org_id', $user->org_id)->orderBy('plant_name')->get();
        return view('energy_sales.edit', compact('energy_sale', 'plants'));
    }

    public function update(Request $request, EnergySale $energy_sale)
    {
        $user = Auth::user();
        if ($user->role?->name === 'admin') {
            return redirect()->route('energy_sales.index')->with('error', 'Админ мэдээ засах эрхгүй.');
        }
        if ($energy_sale->org_id !== $user->org_id) {
            return redirect()->route('energy_sales.index')->with('error', 'Зөвшөөрөлгүй үйлдэл.');
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
        if (!$plant || $plant->org_id !== $user->org_id) {
            return redirect()->back()->with('error', 'Зөвшөөрөлгүй үйлдэл.');
        }
        $data           = $request->all();
        $data['org_id'] = $plant->org_id;

        $energy_sale->update($data);
        return redirect()->route('energy_sales.index')->with('success', 'Борлуулалтын мэдээ амжилттай шинэчлэгдлээ.');
    }

    public function destroy(EnergySale $energy_sale)
    {
        $user = Auth::user();
        if ($user->role?->name === 'admin') {
            return redirect()->route('energy_sales.index')->with('error', 'Админ мэдээ устгах эрхгүй.');
        }
        if ($energy_sale->org_id !== $user->org_id) {
            return redirect()->route('energy_sales.index')->with('error', 'Зөвшөөрөлгүй үйлдэл.');
        }

        $energy_sale->delete();
        return redirect()->route('energy_sales.index')->with('success', 'Борлуулалтын мэдээ устгагдлаа.');
    }
}
