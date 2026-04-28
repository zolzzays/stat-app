<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Role;
use App\Models\Organization;

class UserController extends Controller
{
    // Login view-г харуулах
    public function showLoginForm()
    {
        return view('admin.login'); // admin/login.blade.php байх ёстой
    }

    // Login хийх
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $username = $request->input('username');
        $password = $request->input('password');

        $user = User::where('username', $username)->first();

        if (!$user) {
            return back()->with('error', 'Username буруу байна');
        }

        // 1. bcrypt password шалгах
        if (Hash::check($password, $user->password)) {
            Auth::login($user);
            return redirect('/dashboard');
        }

        // 2. Хуучин md5 password бол хөрвүүлэх
        if ($user->password === md5($password)) {
            $user->password = Hash::make($password);
            $user->save();
            Auth::login($user);
            return redirect('/dashboard');
        }

        return back()->with('error', 'Нууц үг буруу байна');
    }

    // Logout
    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }

    // ========== Хэрэглэгч удирдах ==========

    // Хэрэглэгчдийн жагсаалт
    public function index()
    {
        $users = User::with(['role', 'organization'])->get();
        return view('users.index', compact('users'));
    }

    // Шинэ хэрэглэгч нэмэх form
    public function create()
    {
        $roles = Role::all();
        $orgs  = Organization::orderBy('org_name')->get();
        return view('users.create', compact('roles', 'orgs'));
    }

    // Шинэ хэрэглэгч хадгалах
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'role_id'  => 'nullable|exists:roles,id',
            'org_id'   => 'nullable|exists:organizations,id',
        ]);

        User::create([
            'name'     => $request->name,
            'username' => $request->username,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role_id'  => $request->role_id,
            'org_id'   => $request->org_id,
        ]);

        return redirect()->route('users.index')->with('success', 'Хэрэглэгч амжилттай нэмэгдлээ.');
    }

    // Засах form
    public function edit($id)
    {
        $user  = User::findOrFail($id);
        $roles = Role::all();
        $orgs  = Organization::orderBy('org_name')->get();
        return view('users.edit', compact('user', 'roles', 'orgs'));
    }

    // Засах хадгалах
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name'     => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $id,
            'email'    => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|string|min:6|confirmed',
            'role_id'  => 'nullable|exists:roles,id',
            'org_id'   => 'nullable|exists:organizations,id',
        ]);

        $data = [
            'name'     => $request->name,
            'username' => $request->username,
            'email'    => $request->email,
            'role_id'  => $request->role_id,
            'org_id'   => $request->org_id,
            'position' => $request->position,
            'phone'    => $request->phone,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('users.index')->with('success', 'Хэрэглэгчийн мэдээлэл шинэчлэгдлээ.');
    }

    // Устгах
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if ($user->id === Auth::id()) {
            return redirect()->route('users.index')->with('error', 'Өөрийгөө устгах боломжгүй.');
        }

        $user->delete();

        return redirect()->route('users.index')->with('success', 'Хэрэглэгч устгагдлаа.');
    }
}