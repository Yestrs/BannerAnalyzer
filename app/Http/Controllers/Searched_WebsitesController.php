<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Auth;
use DOMDocument;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Http\Controllers\LogsController;
use Symfony\Component\DomCrawler\Crawler;
use Illuminate\Http\Request;
use App\Models\Searched_websites;
use SebastianBergmann\LinesOfCode\Exception;

class Searched_WebsitesController extends Controller
{

    public $bug = 0;
    function getData()
    {
        $websites = Searched_websites::orderBy('created_at', 'DESC')->paginate(10);

        return view('admin.a_websites', compact('websites'));
    }

    function getAnalyzedWebsitesData($id)
    {
        $website = Searched_websites::find($id);
        $obj = json_decode($website->data);
        return view('public.p_results', compact('obj'));
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
        $obj->image_extensions = $this->countImageExtensions($obj->image_urls);
        $obj->image_loading_speed = $this->calculateLoadingSpeed($obj->image_urls);
        $obj->image_resolution = $this->getImageSpaceTaken($obj->image_urls);




















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



    function getImageLinks($url)
    {
        $html = file_get_contents($url);

        $dom = new DOMDocument();
        @$dom->loadHTML($html);

        $imageLinks = array();

        foreach ($dom->getElementsByTagName('img') as $img) {
            $src = $img->getAttribute('src');

            // Check if the URL is relative, and if so, prepend the base URL
            if (!filter_var($src, FILTER_VALIDATE_URL)) {
                $base_url = rtrim($url, '/');
                $src = $base_url . '/' . ltrim($src, '/');
            }

            // Remove any parameters or anything after the extension
            $src = preg_replace('/\?.*/', '', $src);


            if (preg_match('/\.(png|jpe?g|gif)$/i', $src) && !preg_match('/\.svg$/i', $src)) {
                $imageLinks[] = $src;
            }
        }

        return $imageLinks;
    }


    function countImageExtensions($urls)
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



    function calculateLoadingSpeed(array $imageUrls): array
    {
        $speed = 10; // internet speed in Mbps
        $loadingTimes = [];

        foreach ($imageUrls as $url) {
            $headers = get_headers($url, 1);
            $fileSize = isset($headers['Content-Length']) ? $headers['Content-Length'] : null;

            if ($fileSize) {
                $loadingTime = $fileSize / ($speed * 125000);
                $loadingTimes[$url] = round($loadingTime, 2); // round to 2 decimal places
            }
        }

        return $loadingTimes;
    }

    function getImageSpaceTaken($imageUrls)
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

    function measureWebsitePerformance($url)
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
        return $endTime - $startTime; // Return the time taken to receive the response
    }


    function calculatePageLoadTime($url)
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
        return $totalLoadTime;
    }

    function calculatePageEachLoadTime($url)
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
            'html' => $totalLoadTime
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
                $extension = pathinfo($url, PATHINFO_EXTENSION);
                if (!isset($loadTimes[$extension])) {
                    $loadTimes[$extension] = 0;
                }
                $loadTimes[$extension] += $loadTime;
            }
        });
        return $loadTimes;
    }
























/*
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
function getImageFileSize($imageUrl) {
// Use Laravel's built-in `storage` facade to retrieve the file size
$fileSizeInBytes = \Storage::size($imageUrl);
// Convert the file size to MB
$fileSizeInMb = round($fileSizeInBytes / 1024 / 1024, 2);
return $fileSizeInMb;
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
$image_links = (object) [];
foreach ($matches[1] as $match) {
if (strpos($url, 'base64') !== false) {
$this->bug++;
} else {
if (parse_url($match, PHP_URL_HOST)) {
$image_links->img_url[] = $match;
} else {
$image_links->img_url[] = parse_url($url, PHP_URL_SCHEME) . '://' . parse_url($url, PHP_URL_HOST) . $match;
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
*/
}