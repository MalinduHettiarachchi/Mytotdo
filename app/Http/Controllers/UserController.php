<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function userregistration(Request $request)
{
    try {
        // Validate the request data
        $request->validate([
            'username' => 'required|string|max:255',
            'userphone' => 'required|string|max:15',
            'useremail' => 'required|string|email|max:255|unique:users,Email',
            'userpassword' => 'required|string|min:8',
            'rolevalue' => 'required|integer',
        ]);

        // Create a new user instance
        $user = new User();
        $user->Name = $request->username;
        $user->Phone_Number = $request->userphone;
        $user->Email = $request->useremail;
        $user->Password = Hash::make($request->userpassword); // Hash the password
        $user->Role_Value = $request->rolevalue;

        // Save the user to the database
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Registration successful!'
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Error: ' . $e->getMessage()
        ], 500); // Return a 500 status code for server errors
    }
}
}