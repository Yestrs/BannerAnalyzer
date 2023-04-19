<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Auth;
use DOMDocument;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Http\Controllers\LogsController;

use Illuminate\Http\Request;
use App\Models\Searched_websites;
use SebastianBergmann\LinesOfCode\Exception;

class Searched_WebsitesController extends Controller
{

    public $bug = 0;
    function getData()
    {
        $websites = Searched_websites::orderBy('created_at','DESC')->paginate(10);

        return view('admin.a_websites', compact('websites'));
    }

    function getAnalyzedWebsitesData($id)
    {
        $website = Searched_websites::find($id);
        $obj = json_decode($website->data);
        return view('public.p_results', compact('obj'));
    }
    // make a constructor
    function analyzeWebsite(Request $request)
    {
        $image_count = 0;
        $banner_count = 0;
        $total_image_size = 0;
        $total_banner_size = 0;
        $obj = (object) [];

        $url = $request->input('url');
        $obj->url = $url;
        $response = Http::get($url);
        $html = $response->body();

        preg_match_all('/<img [^>]*>/', $html, $matches);
        foreach ($matches[0] as $match) {
            $doc = new DOMDocument();
            @$doc->loadHTML($match);
            $image_count++;
        }
        preg_match_all('/<[^>]*class\s*=\s*["\'].*banner.*["\'][^>]*>/i', $html, $matches);
        foreach ($matches[0] as $match) {
            $doc = new DOMDocument();
            @$doc->loadHTML($match);
            $banner_count++;
        }
        $obj->bug_count = $this->bug;
        $obj->image_count = $image_count;
        $obj->banner_count = $banner_count;
        $obj->img_urls = $this->collect_image_links($url);
        $obj->img_speeds = $this->getImageLoadingSpeeds($obj->img_urls);
        $obj->loading_speed = $this->server_response_handle_time($url);

        if (auth()->check()) {
            $obj->last_searched_by = Auth::user()->id;
        } else {
            $obj->last_searched_by = NULL;
        }

        $name = parse_url($url, PHP_URL_HOST);
        $data = json_encode($obj);
        $existingRecord = Searched_websites::where('domain', $url)->first();
        if ($existingRecord) {
            $existingRecord->update([
                'name' => $name,
                'data' => $data,
                'points' => 20,
                'search_times' => DB::raw('search_times + 1'),
                'last_searched_by' => $obj->last_searched_by,
                'last_searched_by_date' => Carbon::now()
            ]);
            $searched_website = $existingRecord;
        } else {
            $searched_website = Searched_websites::create([
                'name' => $name,
                'domain' => $url,
                'data' => $data,
                'points' => 20,
                'search_times' => 1,
                'first_searched_by' => $obj->last_searched_by,
                'first_searched_by_date' => Carbon::now()
            ]);
        }
        $log = new LogsController();
        $log->logAction('searched_website', $searched_website->id, Null);

        return view('public.p_results', compact('obj'));
    }


    protected function server_response_handle_time($url)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $headers = explode("\n", trim(substr($response, 0, curl_getinfo($ch, CURLINFO_HEADER_SIZE))));
        $loadTime = curl_getinfo($ch, CURLINFO_TOTAL_TIME);
        curl_close($ch);
        $result = array(
            'url' => $url,
            'httpCode' => $httpCode,
            'loadTime' => $loadTime,
        );
        return $result;
    }


    function calculateLoadingSpeed($url)
    {
        $client = new Client();
        $start_time = microtime(true);
        $response = $client->request('GET', $url);
        $end_time = microtime(true);
        $loading_speed = round(($end_time - $start_time) * 1000, 2);
        return $loading_speed;
    }

    function collect_image_links($url)
    {
        $html = file_get_contents($url);
        $regex = '/<img[^>]+src="([^">]+)"/';
        preg_match_all($regex, $html, $matches);
        $image_links = array();
        foreach ($matches[1] as $match) {
            if (strpos($url, 'base64') !== false) {
                $this->bug++;
            } else {
                if (parse_url($match, PHP_URL_HOST)) {
                    $image_links[] = $match;
                } else {
                    $image_links[] = parse_url($url, PHP_URL_SCHEME) . '://' . parse_url($url, PHP_URL_HOST) . $match;
                }
            }
        }
        return $image_links;
    }

    function getImageLoadingSpeeds(array $urls): array
    {
        $speeds = [];
        $maxSpeed = 10 * 1024 * 1024 / 8;
        foreach ($urls as $url) {
            if (strpos($url, 'base64') !== false) {
                $this->bug++;
            } else {
                $start = microtime(true);
                $size = getimagesize($url);
                if (is_array($size)) {
                    $end = microtime(true);
                    $time = $end - $start;
                    $speed = $size[0] * $size[1] * 4 / $time;
                    $speeds[$url] = round($speed / $maxSpeed, 2);
                } else {
                    $speeds[$url] = 0;
                }
            }

        }

        return $speeds;
    }

}