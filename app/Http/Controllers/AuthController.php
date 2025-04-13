<?php

namespace App\Http\Controllers;

use App\Models\User;
use Hash;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function index()
    {
        return view('login');
    }

    public function login()
    {
        $credentials = request()->validate([
            'email' => 'required|string',
            'password' => 'required',
        ]);

        if (auth()->attempt($credentials)) {
            return redirect()->intended('dashboard')->with('success', 'Login Berhasil');
        }

        return redirect()->back()->withErrors([
            'username' => 'Username atau password salah',
        ]);
    }

    public function logout()
    {
        auth()->logout();

        return redirect('/login')->with('success', 'Logout Berhasil');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:tuser',
            'password' => 'required|string|min:8',
            'role' => 'required|string|in:admin,produksi',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
        ]);

        return redirect()->back()->with('success', 'Berhasil membuat user baru');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.edit-user', compact('user'));
    }
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:tuser,email,' . $id,
            'password' => 'nullable|string|min:8',
            'role' => 'required|string|in:admin,produksi',
        ]);

        $user = User::findOrFail($id);
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        if ($request->filled('password')) {
            $user->password = Hash::make($validated['password']);
        }
        $user->role = $validated['role'];
        $user->save();

        return redirect()->back()->with('success', 'Berhasil mengupdate user');
    }
    
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->back()->with('success', 'Berhasil menghapus user');
    }
}
