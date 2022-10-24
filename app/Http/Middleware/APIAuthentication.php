<?php

namespace App\Http\Middleware;

use App\Models\Apitoken;
use Closure;
use Illuminate\Http\Request;

class APIAuthentication
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Tjekker Header for Bearer Token Authentication
        $token = $request->bearerToken();

        // Tjekker om Token fra Bearer Token Authentication er i systemet
        $api_token = Apitoken::where('token','=', $token)->first();

        // Hvis Token er i systemet accepteres http request'en
        if ($api_token) {
            return $next($request);
        }

        // Ellers sendes en 403 Unauthenticated response
        return response([
            'message' => 'Unauthenticated'
        ], 403);
    }
}
