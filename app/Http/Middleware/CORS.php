<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

class CORS
{
    /**
     * Handle an incoming request
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return $response
     */
    public function handle($request, Closure $next)
    {
        // Origin whitelist array
        $allowedOrigins = [
            'http://localhost:3000',
            'http://localhost'
        ];

        $origin = $request->header('Origin');

        // Check for origin in CORS whitelist array
        if (in_array($origin, $allowedOrigins))
        {
            $headers = [
                'Access-Control-Allow-Origin'       => $origin,
                'Access-Control-Allow-Methods'      => 'POST, GET, OPTIONS, PUT, DELETE',
                'Access-Control-Allow-Credentials'  => 'true',
                'Access-Control-Max-Age'            => '86400',
                'Access-Control-Allow-Headers'      => 'Content-Type, Authorization, X-Requested-With'
            ];

            // Handle pre-flight requests
            if ($request->isMethod('OPTIONS'))
                return response()->json(['method' => 'OPTIONS'], 200, $headers);

            $response = $next($request);

            // Prepare headers in response
            foreach ($headers as $key => $value) {
                $response->header($key, $value);
            }

            return $response;
        }
        // Handle the case when the origin is not in the whitelist
        // else
            // return response()->json(['error' => 'Origin not allowed'], 403);
    }
}