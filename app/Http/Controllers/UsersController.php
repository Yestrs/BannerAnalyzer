<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UsersController extends Controller
{
    function getData() {
        $users = User::all();

        return view('admin.a_users', compact('users'));
    }
}
