<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;

class RoleController extends Controller
{
    public function showLoginForm()
    {
        $roles = Role::all(); // Fetch all roles from the roles table
        return view('login', compact('roles'));
    }

    public function showRegisterForm()
    {
        $roles = Role::all(); // Fetch all roles from the roles table
        return view('register', compact('roles'));
    }
    
}
