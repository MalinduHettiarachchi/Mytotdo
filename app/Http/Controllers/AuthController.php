<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

        if (
            Auth::attempt([
                'Email' => $request->email,
                'Password' => $request->password,
                'Role_Value' => $request->role,
            ])
        ) {
            return response()->json([
                'success' => true,
                'message' => 'Login successful!',
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Invalid credentials.',
            ], 401); // Unauthorized status code
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}