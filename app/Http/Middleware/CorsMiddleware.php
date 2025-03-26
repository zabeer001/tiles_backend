<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CorsMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // return $next($request);
        $response = $next($request);

        $response->header('Access-Control-Allow-Origin', 'http://localhost:3000')
                 ->header('Access-Control-Allow-Methods', 'POST, GET, OPTIONS, DELETE, PUT')
                 ->header('Access-Control-Allow-Headers', 'Content-Type, Authorization');

        // Handle preflight request
        if ($request->isMethod('OPTIONS')) {
            return response()->json('OK', 200);
        }

        return $response;
    }
}
