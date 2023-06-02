<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    function getData() {
        $users = User::orderBy('created_at','DESC')->paginate(10);

        return view('admin.a_users', compact('users'));
    }

    // Noņemt lietotājam piekļuvi pie sistēmas.
    function ban(Request $request) {
        $user = User::find($request->id);
        if ($user->is_banned == 1) {
            $user->is_banned = 0;
        } else {
            $user->is_banned = 1;
            if (Auth::id() == $user->id) {
                Auth::logout(); // Log out the user
            }
        }
        $user->save();
        return redirect()->route('admin.a_users'); 
    }
    
    // Piešķir lietotājam admin privilēģijas
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
