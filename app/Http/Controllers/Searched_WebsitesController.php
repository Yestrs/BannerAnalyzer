<?php

namespace App\Http\Controllers;


use Auth;
use DOMDocument;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Http\Controllers\LogsController;
use App\Http\Controllers\CommentsController;
use Symfony\Component\DomCrawler\Crawler;
use Illuminate\Http\Request;
use App\Models\Searched_websites;
use GuzzleHttp\Exception\RequestException;

class Searched_WebsitesController extends Controller
{

    public $bug = 0;
    function getData()
    {
        $websites = Searched_websites::orderBy('updated_at', 'DESC')->paginate(10);

        return view('admin.a_websites', compact('websites'));
    }

    public function removeWebsitesResults(Request $request) {
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

    function getLeaderboardData() {

        $obj = (object) [];

        $top_3 = Searched_websites::orderBy('points', 'ASC')->take(3)->get();

        $top = Searched_websites::orderBy('points', 'ASC')->take(100)->paginate(10);

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
        $obj = (object) [];
        $url = $request->input('url');
        $obj->url = $url;


        $obj->recieved_response_speed = $this->measureWebsitePerformance($url);
        $obj->page_load_time = $this->calculatePageLoadTime($url);
        $obj->page_each_load_time = $this->calculatePageEachLoadTime($url);



        $obj->image_urls = $this->getImageLinks($url);

        if (!is_array($obj->image_urls)) {
            $obj->errors = "This site is protected, cant access images.";
            return view('public.p_results', compact('obj'));
        }

        $obj->image_extensions = $this->countImageExtensions($obj->image_urls);
        $obj->image_loading_speed = $this->calculateLoadingSpeed($obj->image_urls);
        $obj->avg_image_loading_speed = $this->calculateAvarageImageLoadingSpeed($obj->image_loading_speed);
        $obj->image_resolution = $this->getImageSpaceTaken($obj->image_urls);
        $obj->image_count = count($obj->image_urls);


        if (auth()->check()) {
            $obj->last_searched_by = Auth::user()->id;
        } else {
            $obj->last_searched_by = NULL;
        }
        $name = parse_url($url, PHP_URL_HOST);
        $obj->name = $name;

        $points = (int)($obj->image_count * $obj->avg_image_loading_speed * 100) + ($obj->recieved_response_speed * 100) + ($obj->page_load_time * 100);

        $obj->points = $points;

        $data = json_encode($obj);
        $existingRecord = Searched_websites::where('domain', $url)->first();
        if ($existingRecord) {
            $existingRecord->update([
                'name' => $name,
                'data' => $data,
                'points' => $points,
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
                'points' => $points,
                'search_times' => 1,
                'first_searched_by' => $obj->last_searched_by,
                'first_searched_by_date' => Carbon::now()
            ]);
        }
        $log = new LogsController();
        $log->logAction('searched_website', $searched_website->id, Null);
        return view('public.p_results', compact('obj'));
    }



    protected function getImageLinks($url)
    {
        $client = new Client();
        try {
            $response = $client->get($url);
            $html = $response->getBody()->getContents();
        } catch (RequestException $e) {
            exit;
            if ($e->getResponse() && $e->getResponse()->getStatusCode() == 405) {
                exit;
                //return "Error: HTTP request failed. Method not allowed.";
            } else {
                return $e->getMessage();
            }
        }


        $dom = new DOMDocument();
        @$dom->loadHTML($html);

        $imageLinks = array();

        foreach ($dom->getElementsByTagName('img') as $img) {
            $src = $img->getAttribute('src');

            if (!filter_var($src, FILTER_VALIDATE_URL)) {
                $base_url = rtrim($url, '/');
                $src = $base_url . '/' . ltrim($src, '/');
            }

            $src = preg_replace('/\?.*/', '', $src);


            if (preg_match('/\.(png|jpe?g|gif)$/i', $src) && !preg_match('/\.svg$/i', $src)) {
                $imageLinks[] = $src;
            }
        }

        return $imageLinks;
    }


    protected function countImageExtensions($urls)
    {
        $extensions = [];
        foreach ($urls as $url) {
            $parsed = parse_url($url);
            $path = $parsed['path'];
            $extension = pathinfo($path, PATHINFO_EXTENSION);
            if (!empty($extension)) {
                if (isset($extensions[$extension])) {
                    $extensions[$extension]++;
                } else {
                    $extensions[$extension] = 1;
                }
            }
        }
        return $extensions;
    }



    protected function calculateLoadingSpeed(array $imageUrls): array
    {
        $speed = 10; // internet speed in Mbps
        $loadingTimes = [];

        foreach ($imageUrls as $url) {
            $headers = get_headers($url, 1);
            $fileSize = isset($headers['Content-Length']) ? $headers['Content-Length'] : null;

            if ($fileSize) {
                $loadingTime = $fileSize / ($speed * 125000);
                $loadingTimes[] = round($loadingTime, 3); // round to 2 decimal places
            }
        }

        return $loadingTimes;
    }

    protected function getImageSpaceTaken($imageUrls)
    {
        $spaceTaken = array();
        foreach ($imageUrls as $url) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $imageContent = curl_exec($ch);

            if (curl_errno($ch)) {
                continue;
            }

            if (!$imageInfo = @getimagesizefromstring($imageContent)) {
                continue;
            }

            $width = $imageInfo[0];
            $height = $imageInfo[1];

            $spaceTaken[$url] = array(
                'width' => $width,
                'height' => $height,
                'totalSpaceTaken' => $width * $height
            );
            curl_close($ch);
        }
        return $spaceTaken;
    }

    protected function measureWebsitePerformance($url)
    {
        $client = new Client();
        $startTime = microtime(true);
        try {
            $response = $client->request('GET', $url);
        } catch (GuzzleException $e) {
            // Handle any exceptions that may occur
            return -1; // Return -1 to indicate an error
        }
        $endTime = microtime(true);
        return round($endTime - $startTime, 3); // Return the time taken to receive the response
    }


    protected function calculatePageLoadTime($url)
    {
        $client = new Client();
        $startTime = microtime(true);
        try {
            $response = $client->request('GET', $url);
        } catch (GuzzleException $e) {
            return -1;
        }
        $endTime = microtime(true);
        $html = (string) $response->getBody();
        $crawler = new Crawler($html);
        $totalLoadTime = $endTime - $startTime;
        $crawler->filter('img, script, link[rel="stylesheet"]')->each(function ($node) use (&$totalLoadTime) {
            $url = $node->attr('src') ?? $node->attr('href');
            if ($url) {
                $start = microtime(true);
                $client = new Client();
                try {
                    $client->request('GET', $url);
                } catch (GuzzleException $e) {
                    return;
                }
                $end = microtime(true);
                $loadTime = $end - $start;
                $totalLoadTime += $loadTime;
            }
        });
        return round($totalLoadTime, 3);
    }

    protected function calculatePageEachLoadTime($url)
    {
        $client = new Client();
        $startTime = microtime(true);
        try {
            $response = $client->request('GET', $url);
        } catch (GuzzleException $e) {
            return ['error' => -1];
        }
        $endTime = microtime(true);
        $html = (string) $response->getBody();
        $crawler = new Crawler($html);
        $totalLoadTime = $endTime - $startTime;
        $loadTimes = [
            'html' => round($totalLoadTime, 3)
        ];
        $crawler->filter('img, script, link[rel="stylesheet"]')->each(function ($node) use (&$loadTimes) {
            $url = $node->attr('src') ?? $node->attr('href');
            if ($url) {
                $start = microtime(true);
                $client = new Client();
                try {
                    $client->request('GET', $url);
                } catch (GuzzleException $e) {
                    return;
                }
                $end = microtime(true);
                $loadTime = $end - $start;
                $extension = pathinfo(parse_url($url, PHP_URL_PATH), PATHINFO_EXTENSION);
                if ( $extension == "") { 
                    $extension = "other";
                }
                if (!isset($loadTimes[$extension])) {
                    $loadTimes[$extension] = 0;
                }
                $loadTimes[$extension] += round($loadTime, 3);
            }
        });
        return $loadTimes;
    }

    protected function calculateAvarageImageLoadingSpeed($img_loading_speed_array)
    {
        $total = 0;
        foreach ($img_loading_speed_array as $value) {
            $total += $value;
        }
        if (count($img_loading_speed_array) > 0) {
            return round($total / count($img_loading_speed_array), 3);
        } else {
            return 0;
        }
        
    }



}