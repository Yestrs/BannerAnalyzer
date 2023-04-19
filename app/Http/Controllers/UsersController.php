<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UsersController extends Controller
{
    function getData() {
        $users = User::orderBy('created_at','DESC')->paginate(10);

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

    function setAdmin(Request $request) {
        $user = User::find($request->id);
        if ($user->is_admin == 1) {
            $user->is_admin = 0;
        } else {
            $user->is_admin = 1;
        }
        $user->save();
        return redirect()->route('admin.a_users');
    }
}
