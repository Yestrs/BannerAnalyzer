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

    function ban(Request $request) {
        $user = User::find($request->id);
        if ($user->is_banned == 1) {
            $user->is_banned = 0;
        } else {
            $user->is_banned = 1;
        }
        $user->save();
        return redirect()->route('admin.a_users'); 
    }
}
