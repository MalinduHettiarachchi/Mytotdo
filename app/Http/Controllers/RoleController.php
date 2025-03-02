<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;

class RoleController extends Controller
{
    public function getRoles()
    {
        $roles = Role::all(); // Fetch all roles from the roles table
        return view('login', compact('roles')); // Pass roles to the view
    }
}