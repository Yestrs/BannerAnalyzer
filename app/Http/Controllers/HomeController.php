<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function adminHome() {
        $home_obj = (object) [];
        

        $home_obj->total_websites_analyzed = DB::table('searched_websites')->count();
        $home_obj->total_users = DB::table('users')->count();
        $home_obj->total_unique_websites_analyzed = DB::table('searched_websites')->distinct()->count('name');
        $home_obj->total_banned_users = DB::table('users')->where('is_banned', 1)->count();
        $home_obj->total_logs = DB::table('logs')->count();
        $home_obj->total_admins = DB::table('users')->where('is_admin', 1)->count();
        

        return view('admin.a_home', compact('home_obj'));

    }
}
