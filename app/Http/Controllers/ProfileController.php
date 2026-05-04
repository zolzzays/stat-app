<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('profile.edit', ['user' => Auth::user()]);
    }

    public function users()
    {
        $users = User::with(['organization', 'powerPlant'])
            ->leftJoin('organizations', 'users.org_id', '=', 'organizations.id')
            ->orderBy('organizations.org_code')
            ->orderBy('users.name')
            ->select('users.*')
            ->get();
        return view('profile.users', compact('users'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name'     => 'required|string|max:255',
            'position' => 'nullable|string|max:255',
            'phone'    => 'nullable|string|max:50',
        ]);

        $user->update([
            'name'     => $request->name,
            'position' => $request->position,
            'phone'    => $request->phone,
        ]);

        return back()->with('success', 'Мэдээлэл амжилттай шинэчлэгдлээ.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password'      => 'required',
            'password'              => 'required|string|min:6|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Одоогийн нууц үг буруу байна.'])->withFragment('password');
        }

        $user->update(['password' => Hash::make($request->password)]);

        return back()->with('success_password', 'Нууц үг амжилттай солигдлоо.')->withFragment('password');
    }
}
