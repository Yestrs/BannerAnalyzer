<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Auth;
use DOMDocument;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

use Illuminate\Http\Request;
use App\Models\Searched_websites;

class Searched_WebsitesController extends Controller
{
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

        // Image / Banner Count and Size
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

        // Image loading speed calculation
        //$image_loading_speed = $total_image_size / ($image_count * 1024); // Assuming 1MBps connection speed

        $obj->image_count = $image_count;
        $obj->banner_count = $banner_count;
        //$obj->total_image_size = $total_image_size;
        // $obj->total_banner_size = $total_banner_size;
        //$obj->image_loading_speed = $image_loading_speed;


        $obj->img_urls = $this->collect_image_links($url);

        $obj->img_speeds = $this->getImageLoadingSpeeds($obj->img_urls);

        //$obj->img_size = $this->get_image_sizes($obj->img_urls);



        //loading_speed
        $loading_speed = $this->server_response_handle_time($url);

        $obj->loading_speed = $loading_speed;

        //$image_size = $this->getExternalImagesSize($url);
        //$obj->image_size = $image_size;


        // vajag nočekot ja nav users tad lai neraksta id
        $obj->last_searched_by = Auth::user()->id;

        return view('public.p_results', compact('obj'));
    }


    function server_response_handle_time($url)
    {
        // Initialize cURL session
        $ch = curl_init($url);
        // Set cURL options
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        // Execute cURL request
        $response = curl_exec($ch);
        // Get HTTP response code
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        // Get headers
        $headers = explode("\n", trim(substr($response, 0, curl_getinfo($ch, CURLINFO_HEADER_SIZE))));
        // Get total loading time
        $loadTime = curl_getinfo($ch, CURLINFO_TOTAL_TIME);
        // Close cURL session
        curl_close($ch);
        // Initialize result array
        $result = array(
            'url' => $url,
            'httpCode' => $httpCode,
            'loadTime' => $loadTime,
        );
        // Return result array
        return $result;
    }
    
    
    
    


    function collect_image_links($url)
    {
        // Fetch the HTML content of the URL
        $html = file_get_contents($url);

        // Define the regular expression to match image src links
        $regex = '/<img[^>]+src="([^">]+)"/';

        // Find all matches of the regular expression in the HTML content
        preg_match_all($regex, $html, $matches);

        // Extract only the URLs from the matches array
        $image_links = array();
        foreach ($matches[1] as $match) {
            // Check if the URL has an origin
            if (parse_url($match, PHP_URL_HOST)) {
                $image_links[] = $match;
            } else {
                // Set the origin to the URL passed as a parameter
                $image_links[] = parse_url($url, PHP_URL_SCHEME) . '://' . parse_url($url, PHP_URL_HOST) . $match;
            }
        }

        // Return the array of image src links
        return $image_links;
    }

    function getImageLoadingSpeeds(array $urls): array
    {
        $speeds = [];
        $maxSpeed = 10 * 1024 * 1024 / 8; // 10 Mbps to bytes per second

        foreach ($urls as $url) {
            $start = microtime(true); // Get the current time in seconds
            $size = getimagesize($url);
            if (is_array($size)) {
                $end = microtime(true); // Get the time again after loading the image
                $time = $end - $start; // Calculate the loading time in seconds
                $speed = $size[0] * $size[1] * 4 / $time; // Calculate the loading speed in bits per second (assuming 32-bit color depth)
                $speeds[$url] = round($speed / $maxSpeed, 2); // Calculate the loading speed as a fraction of the maximum speed
            } else {
                $speeds[$url] = 0; // Set the loading speed to 0 if $size is not an array
            }
        }

        return $speeds;
    }

}