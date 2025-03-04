<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;


class LogoutController extends Controller
{
    


    public function __invoke()
    {
        try {
            // Invalidate the token
            JWTAuth::invalidate(JWTAuth::getToken());

            // Return success response
            return response()->json(['message' => 'Successfully logged out']);
        } catch (JWTException $e) {
            // Handle the error if token invalidation fails
            return response()->json(['error' => 'Could not log out, please try again later'], 500);
        }
    }
}
