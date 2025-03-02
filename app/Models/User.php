<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $fillable = ['Name', 'Phone_Number', 'Email', 'Password', 'Role_Value'];
}