<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class AuthController extends Controller
{
    /**
     * Menampilkan form login admin.
     */
    public function adminLogin(): View|RedirectResponse
    {
        if (Auth::check()) {
            return Auth::user()->role === 'admin'
                ? redirect('/admin/dashboard')
                : redirect('/user/dashboard');
        }

        return view('admin.login');
    }

    /**
     * Menampilkan form login user/peserta.
     */
    public function userLogin(): View|RedirectResponse
    {
        if (Auth::check()) {
            return Auth::user()->role === 'user'
                ? redirect('/user/dashboard')
                : redirect('/admin/dashboard');
        }

        return view('user.login');
    }

    /**
     * Menampilkan form registrasi user.
     */
    public function register(): View|RedirectResponse
    {
        if (Auth::check()) {
            return redirect('/user/dashboard');
        }

        return view('user.register');
    }

    /**
     * Proses pendaftaran akun user baru.
     */
    public function storeRegister(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'school_name' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:25'],
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email ini sudah terdaftar. Silakan gunakan email lain atau login.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal harus 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => strtolower(trim($validated['email'])),
            'password' => Hash::make($validated['password']),
            'role' => 'user',
            'school_name' => $validated['school_name'] ?? null,
            'phone' => $validated['phone'] ?? null,
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect('/user/dashboard')
            ->with('success', 'Registrasi berhasil! Selamat datang di platform ARENA Z.');
    }

    /**
     * Proses login user atau admin.
     */
    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ], [
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
        ]);

        // Tentukan target role: dari form input 'role' atau dari URL yang diakses
        $targetRole = $request->input('role');
        if (! $targetRole) {
            $targetRole = $request->is('admin*') ? 'admin' : 'user';
        }

        $remember = $request->boolean('remember');

        if (Auth::attempt([
            'email' => strtolower(trim($credentials['email'])),
            'password' => $credentials['password'],
        ], $remember)) {
            $user = Auth::user();

            // Verifikasi kecocokan role akun dengan pintu login yang dimasuki
            if ($user->role !== $targetRole) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                if ($targetRole === 'admin') {
                    return back()
                        ->withInput($request->only('email', 'remember'))
                        ->withErrors([
                            'email' => 'Akses ditolak: Akun Anda terdaftar sebagai Peserta, bukan Administrator.',
                        ]);
                }

                return back()
                    ->withInput($request->only('email', 'remember'))
                    ->withErrors([
                        'email' => 'Akun Administrator silakan login melalui halaman login khusus Admin.',
                    ]);
            }

            $request->session()->regenerate();

            if ($user->role === 'admin') {
                return redirect()->intended('/admin/dashboard')
                    ->with('success', 'Selamat datang kembali, Administrator ARENA Z!');
            }

            return redirect()->intended('/user/dashboard')
                ->with('success', 'Login berhasil! Selamat datang di ARENA Z.');
        }

        return back()
            ->withInput($request->only('email', 'remember'))
            ->withErrors([
                'email' => 'Email atau password yang Anda masukkan salah.',
            ]);
    }

    /**
     * Proses logout dari sistem.
     */
    public function logout(Request $request): RedirectResponse
    {
        $role = Auth::user()?->role ?? 'user';

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        if ($role === 'admin') {
            return redirect('/admin/login')
                ->with('success', 'Anda telah berhasil logout dari Portal Admin.');
        }

        return redirect('/user/login')
            ->with('success', 'Anda telah berhasil logout dari ARENA Z.');
    }
}
