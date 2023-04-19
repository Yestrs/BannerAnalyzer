<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Logs;
use Illuminate\Support\Facades\Auth;

class LogsController extends Controller
{
    function getData() {
        $logs = Logs::with('user_made_by', 'user_made_to')->orderBy('created_at','DESC')->paginate(10);

        return view('admin.a_logs', compact('logs'));
    }
    

    function logAction($action, $data, $changes_made_to)
    {
       
        $log = new Logs();
        $log->action = $action;
        $log->data = $data;
        if (auth()->check()) {
            $log->changes_made_by = Auth::user()->id;
        } else {
            $log->changes_made_by = NULL;
        }
        if ($changes_made_to) {
            $log->changes_made_to = $changes_made_to;
        } else {
            $log->changes_made_to = NULL;
        }
        $log->save();





        
    }

}
