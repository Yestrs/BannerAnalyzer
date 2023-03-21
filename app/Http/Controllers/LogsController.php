<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Logs;

class LogsController extends Controller
{
    function getData() {
        $logs = Logs::with('user_made_by', 'user_made_to')->get();

        return view('admin.a_logs', compact('logs'));
    }
    
}
