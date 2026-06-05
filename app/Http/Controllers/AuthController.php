<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    /**
     * Register a new user.
     * Validates input strictly, including secure password requirements.
     */
    public function register(Request $request)
    {
        // 1. Validate the incoming request data
        $request->validate([
            // Cambiamos el máximo a 16 caracteres
            'name' => 'required|string|max:16',

            // Cambiamos el máximo a 100 caracteres
            'email' => 'required|string|email|max:100|unique:users',

            'role_id' => 'required|exists:roles,id',
            'password' => ['required', 'confirmed', Password::min(8)->letters()->numbers()->symbols()],
        ]);

        // 2. Create the user in the database
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Encrypt the password
            'role_id' => $request->role_id,
        ]);

        // 3. Return a successful JSON response
        return response()->json([
            'message' => 'User successfully registered',
            'user' => $user
        ], 201);
    }
}
