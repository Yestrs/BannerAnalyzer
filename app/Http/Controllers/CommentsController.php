<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comments;
use Illuminate\Support\Facades\DB;

class CommentsController extends Controller
{

    function getData() {
        $comments = Comments::all();

        return view('admin.a_comments', compact('comments'));
    }

    function getLatestThreeComments() {
        $comments = Comments::orderBy('stars', 'desc')->orderBy('created_at', 'desc')->take(3)->get();

        return view('public.p_about', compact('comments'));
    }

    public function addComment(Request $request) {
        $website_id = DB::table('searched_websites')->where('domain', $request->url)->first()->id;
        $comment = new Comments;
        $comment->comment = request('comment');
        $comment->stars = request('stars');
        $comment->website_id = $website_id;
        $comment->user_id = auth()->user()->id;
        $comment->save();

        return redirect()->back();
    }

    public function removeComment(Request $request) {
        $comment = Comments::find(request('comment_id'));
        $comment->delete();

        return redirect()->back();
    }
}
