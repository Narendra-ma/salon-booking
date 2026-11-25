<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Gerbang akses privat: situs hanya terbuka bagi yang membuka link berisi token.
 * Kalau ACCESS_TOKEN kosong di .env, situs publik seperti biasa.
 */
class PrivateAccess
{
    public function handle(Request $request, Closure $next): Response
    {
        $token = (string) config('app.access_token');

        if ($token === '') {
            return $next($request);
        }

        $given = (string) $request->query('akses', '');

        if ($given !== '' && hash_equals($token, $given)) {
            $request->session()->put('akses_ok', true);

            // Buang token dari URL supaya tidak tersimpan di riwayat atau ikut ter-share
            return redirect($request->url());
        }

        abort_unless($request->session()->get('akses_ok') === true, 403, 'Akses khusus pemilik link.');

        return $next($request)->header('X-Robots-Tag', 'noindex, nofollow');
    }
}
