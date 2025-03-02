<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $fillable = ['Name', 'Phone_Number', 'Email', 'Password', 'Role_Value'];
}