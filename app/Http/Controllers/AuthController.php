<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;  // Add this line to use Hash::check()
use App\Models\User;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
            'role' => 'required|integer',
        ]);

        // Attempt login using email and password fields, and check the role
        $user = User::where('email', $request->email)->first();  // Find user by email

        if ($user && Hash::check($request->password, $user->Password) && $user->Role_Value == $request->role) {
            Auth::login($user); // Log the user in

            return response()->json([
                'success' => true,
                'message' => 'Login successful!',
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Invalid credentials or role.',
            ], 401); // Unauthorized status code
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}