<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class XSSProtection
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $input = $request->all();

        array_walk_recursive($input, function (&$value) {
            $value = strip_tags($value); // Menghapus tag HTML berbahaya
            $value = htmlspecialchars($value, ENT_QUOTES, 'UTF-8'); // Mencegah injeksi script
        });

        $request->merge($input);

        return $next($request);
    }
}
