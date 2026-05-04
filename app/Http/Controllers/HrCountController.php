<?php

namespace App\Http\Controllers;

use App\Models\HrCount;
use App\Models\PowerPlant;
use App\Models\RegType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Exports\HrCountExport;
use Maatwebsite\Excel\Facades\Excel;

class HrCountController extends Controller
{
    public function index(Request $request)
    {
        $user  = Auth::user();
        $year  = $request->input('year');
        $month = $request->input('month');

        $query = HrCount::with(['powerPlant', 'organization']);

        if ($year)  $query->where('year', $year);
        if ($month) $query->where('month', $month);

        if ($user->role?->name === 'admin') {
            if ($request->input('export') === 'excel') {
                $filename = 'hr_count_' . ($year ?: 'all') . '_' . ($month ?: 'all') . '.xlsx';
                return Excel::download(new HrCountExport($year, $month), $filename);
            }
            $rows = $query->join('organizations', 'hr_count.org_id', '=', 'organizations.id')
                          ->orderBy('organizations.org_code')
                          ->select('hr_count.*')
                          ->get();
            return view('hr_count.admin_index', compact('rows', 'year', 'month'));
        }

        $query->where('org_id', $user->org_id);
        if ($request->input('export') === 'excel') {
            $filename = 'hr_count_' . ($year ?: 'all') . '_' . ($month ?: 'all') . '.xlsx';
            return Excel::download(new HrCountExport($year, $month, null, $user->org_id), $filename);
        }
        $rows = $query->get();
        return view('hr_count.index', compact('rows', 'year', 'month'));
    }

    public function create()
    {
        $user = Auth::user();

        if ($user->role?->name === 'admin') {
            return redirect()->route('hr_count.index')->with('error', 'Админ мэдээ нэмэх эрхгүй.');
        }

        $plants   = PowerPlant::with('regType')->where('org_id', $user->org_id)->orderBy('plant_name')->get();
        $regTypes = RegType::orderBy('type_name')->get();
        return view('hr_count.create', compact('plants', 'regTypes'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        if ($user->role?->name === 'admin') {
            return redirect()->route('hr_count.index')->with('error', 'Админ мэдээ нэмэх эрхгүй.');
        }

        $request->validate([
            'power_plant_id' => 'required|exists:power_plants,id',
            'year'           => 'required|integer|min:2000|max:2100',
            'month'          => 'required|integer|min:1|max:12',
            'emp_male'       => 'required|integer|min:0',
            'emp_female'     => 'required|integer|min:0',
            'work_male'      => 'required|integer|min:0',
            'work_female'    => 'required|integer|min:0',
        ]);

        $plant = PowerPlant::find($request->power_plant_id);
        if (!$plant || $plant->org_id !== $user->org_id) {
            return redirect()->back()->with('error', 'Зөвшөөрөлгүй үйлдэл.');
        }
        $data           = $request->all();
        $data['org_id'] = $plant->org_id;

        HrCount::create($data);
        return redirect()->route('hr_count.index')->with('success', 'Хүний нөөцийн мэдээ амжилттай нэмэгдлээ.');
    }

    public function edit(HrCount $hr_count)
    {
        $user = Auth::user();

        if ($user->role?->name === 'admin') {
            return redirect()->route('hr_count.index')->with('error', 'Админ мэдээ засах эрхгүй.');
        }
        if ($hr_count->org_id !== $user->org_id) {
            return redirect()->route('hr_count.index')->with('error', 'Зөвшөөрөлгүй үйлдэл.');
        }

        $plants   = PowerPlant::with('regType')->where('org_id', $user->org_id)->orderBy('plant_name')->get();
        $regTypes = RegType::orderBy('type_name')->get();
        return view('hr_count.edit', compact('hr_count', 'plants', 'regTypes'));
    }

    public function update(Request $request, HrCount $hr_count)
    {
        $user = Auth::user();

        if ($user->role?->name === 'admin') {
            return redirect()->route('hr_count.index')->with('error', 'Админ мэдээ засах эрхгүй.');
        }
        if ($hr_count->org_id !== $user->org_id) {
            return redirect()->route('hr_count.index')->with('error', 'Зөвшөөрөлгүй үйлдэл.');
        }

        $request->validate([
            'power_plant_id' => 'required|exists:power_plants,id',
            'year'           => 'required|integer|min:2000|max:2100',
            'month'          => 'required|integer|min:1|max:12',
            'emp_male'       => 'required|integer|min:0',
            'emp_female'     => 'required|integer|min:0',
            'work_male'      => 'required|integer|min:0',
            'work_female'    => 'required|integer|min:0',
        ]);

        $plant = PowerPlant::find($request->power_plant_id);
        $data  = $request->all();
        $data['org_id'] = $plant?->org_id;

        $hr_count->update($data);
        return redirect()->route('hr_count.index')->with('success', 'Хүний нөөцийн мэдээ амжилттай шинэчлэгдлээ.');
    }

    public function destroy(HrCount $hr_count)
    {
        $user = Auth::user();

        if ($user->role?->name === 'admin') {
            return redirect()->route('hr_count.index')->with('error', 'Админ мэдээ устгах эрхгүй.');
        }
        if ($hr_count->org_id !== $user->org_id) {
            return redirect()->route('hr_count.index')->with('error', 'Зөвшөөрөлгүй үйлдэл.');
        }

        $hr_count->delete();
        return redirect()->route('hr_count.index')->with('success', 'Хүний нөөцийн мэдээ устгагдлаа.');
    }
}
