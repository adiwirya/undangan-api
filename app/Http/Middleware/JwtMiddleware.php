<?php

namespace App\Http\Middleware;

use Closure;
use Exception;

use Firebase\JWT\JWT;
use Firebase\JWT\ExpiredException;
class JwtMiddleware
{
    public function handle($request, Closure $next, $guard = null)
    {
        $token = $request->bearerToken();
        
        if(!$token) {
            return response()->json([
                'error' => 'Token not provided.'
            ], 401);
        }

        $credentials = [];
        try {                                   
            $credentials = JWT::decode($token, 'BCG5fI4rbuypVmRcKfpDeGPT7ZCYy1ny', ['HS256']);
        } catch(ExpiredException $e) {
            return response()->json([
                'error' => 'Provided token is expired.'
            ], 400);
        } catch(Exception $e) {
            return response()->json([
                'error' => 'An error while decoding token.'
            ], 400);
        }

        $request->auth = $credentials;
        return $next($request);
    }
}
