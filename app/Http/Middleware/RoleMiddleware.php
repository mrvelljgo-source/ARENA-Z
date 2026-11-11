<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (! $request->user()) {
            if ($role === 'admin' || $request->is('admin*')) {
                return redirect()->guest('/admin/login')->withErrors([
                    'email' => 'Silakan login sebagai administrator terlebih dahulu.',
                ]);
            }

            return redirect()->guest('/user/login')->withErrors([
                'email' => 'Silakan login terlebih dahulu.',
            ]);
        }

        if ($request->user()->role !== $role) {
            if ($role === 'admin') {
                abort(403, 'Akses khusus admin. Akun Anda tidak memiliki hak akses administrator.');
            }

            abort(403, 'Akses khusus peserta. Akun administrator tidak dapat mengakses area peserta turnamen.');
        }

        return $next($request);
    }
}
