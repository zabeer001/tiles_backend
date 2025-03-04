<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use Dotenv\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class RegisterController extends Controller
{

    public function __invoke(RegisterRequest $request)
    {
        try {
            // Create user with validated data
            $user = User::create([
                'name' => $request->get('name'),
                'email' => $request->get('email'),
                'password' => Hash::make($request->get('password')),
            ]);

            // Generate JWT token for the newly created user
            $token = JWTAuth::fromUser($user);

            // Return the success response with user data and token
            return response()->json(compact('user', 'token'), 201);
        } catch (\Exception $e) {
            // Handle any exceptions (e.g., database errors) gracefully
            return response()->json([
                'status' => 'error',
                'message' => 'User registration failed. Please try again.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
