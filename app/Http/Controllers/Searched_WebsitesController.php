<?php

namespace App\Http\Controllers;

use App\Jobs\AnalyzeWebsiteJob;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Searched_websites;


class Searched_WebsitesController extends Controller
{

    public $bug = 0;
    function getData()
    {
        $websites = Searched_websites::orderBy('updated_at', 'DESC')->paginate(10);
        return view('admin.a_websites', compact('websites'));
    }


    function waitForWebsite(Request $request)
    {
        $domain = $request->query('domain');
        $website = Searched_websites::where('domain', $domain)->first();

        if ($website && $website->last_searched_by_date >= Carbon::now()->subSeconds(5)) {
            return $website->id;
        } else {
            return response()->json(['error' => 'Website not found or not updated recently'], 404);
        }
    }


    public function removeWebsitesResults(Request $request)
    {
        $website = Searched_websites::find(request('id'));
        $website->comments()->update(['website_id' => null]);
        $website->delete();
        return redirect()->back();
    }

    function getAnalyzedWebsitesData($id)
    {
        $website = Searched_websites::find($id);
        $obj = json_decode($website->data);
        $obj->name = $website->name;
        return view('public.p_results', compact('obj'));
    }

    function getLeaderboardData()
    {
        $obj = (object) [];
        $top_3 = Searched_websites::orderBy('points', 'ASC')->where('points', '>=', 500)->take(3)->get();
        $top = Searched_websites::orderBy('points', 'ASC')->where('points', '>=', 500)->take(100)->paginate(10);

        foreach ($top_3 as $top3) {
            $top3arr[] = array(
                'data' => json_decode($top3->data),
                'name' => $top3->name,
                'domain' => $top3->domain,
                'points' => $top3->points,
            );
        }

        $obj->top = $top;
        $obj->top_3 = $top3arr;
        return view('public.p_leaderboard', compact('obj'));
    }



    function analyzeWebsite(Request $request)
    {
        AnalyzeWebsiteJob::dispatch($request->input('url'));
        $url = $request->input('url');

        return view('public.p_results_loading')->with('domain', $url);
    }

}