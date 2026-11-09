<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Menampilkan form login admin
    public function adminLogin()
    {
        return view('admin.login');
    }

    // Menampilkan form login user
    public function userLogin()
    {
        return view('user.login');
    }

    // Menampilkan form registrasi user
    public function register()
    {
        return view('user.register');
    }

    // Proses registrasi user
    public function storeRegister(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
        ]);

        $user->role = 'user';
        $user->save();

        Auth::login($user);

        return redirect('/user/dashboard');
    }

    // Proses login admin dan user
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $role = $request->input('role');

        if (!in_array($role, ['admin', 'user'])) {
            return back()->withErrors([
                'email' => 'Jenis akun tidak valid.',
            ]);
        }

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            if (Auth::user()->role === $role) {
                return $role === 'admin'
                    ? redirect('/admin/dashboard')
                    : redirect('/user/dashboard');
            }

            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }

        return back()->withErrors([
            'email' => 'Email, password, atau jenis akun salah.',
        ]);
    }

    // Proses logout
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/pilih-login');
    }
}
