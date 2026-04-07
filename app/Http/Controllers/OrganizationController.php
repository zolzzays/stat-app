<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use Illuminate\Http\Request;

class OrganizationController extends Controller
{
    public function index()
    {
        $organizations = Organization::all();
        return view('organizations.index', compact('organizations'));
    }

    public function create()
    {
        return view('organizations.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'org_name' => 'required|string|max:255',
            'org_code' => 'required|string|max:50|unique:organizations,org_code',
        ]);

        Organization::create($request->only('org_name', 'org_code'));
        return redirect()->route('organizations.index')->with('success', 'Байгууллага амжилттай нэмэгдлээ.');
    }

    public function edit(Organization $organization)
    {
        return view('organizations.edit', compact('organization'));
    }

    public function update(Request $request, Organization $organization)
    {
        $request->validate([
            'org_name' => 'required|string|max:255',
            'org_code' => 'required|string|max:50|unique:organizations,org_code,' . $organization->id,
        ]);

        $organization->update($request->only('org_name', 'org_code'));
        return redirect()->route('organizations.index')->with('success', 'Байгууллага амжилттай шинэчлэгдлээ.');
    }

    public function destroy(Organization $organization)
    {
        $organization->delete();
        return redirect()->route('organizations.index')->with('success', 'Байгууллага устгагдлаа.');
    }
}
