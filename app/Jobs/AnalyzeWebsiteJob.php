<?php

namespace App\Jobs;

use Auth;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\Client\Response;
use Illuminate\Http\RedirectResponse;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Http\Controllers\LogsController;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Symfony\Component\DomCrawler\Crawler;
use App\Models\Searched_websites;
use GuzzleHttp\Exception\RequestException;

class AnalyzeWebsiteJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $url;

    public function __construct($url)
    {
        $this->url = $url;
    }


    public function getUrl()
    {
        return $this->url;
    }

    public function handle()
    {
        $obj = (object) [];
        $url = $this->url;
        $obj->url = $url;

        $obj->recieved_response_speed = $this->measureWebsitePerformance($url);

        $obj->image_urls = $this->getImageLinks($url);

        $obj->image_urls_test = $this->getImageLinksTest($url);

        $obj->image_extensions = $this->countImageExtensions($obj->image_urls);
        $obj->image_loading_speed = $this->calculateLoadingSpeed($obj->image_urls);
        $obj->total_image_Loading_Speed = $this->totalLoadingSpeed($obj->image_loading_speed);
        $obj->avg_image_loading_speed = $this->calculateAvarageImageLoadingSpeed($obj->image_loading_speed);

        $obj->image_count = count($obj->image_urls);

        if (auth()->check()) {
            $obj->last_searched_by = Auth::user()->id;
        } else {
            $obj->last_searched_by = NULL;
        }
        $name = parse_url($url, PHP_URL_HOST);
        $obj->name = $name;

        $points = (int) ($obj->image_count * $obj->avg_image_loading_speed * 100) + ($obj->recieved_response_speed * 100) + ($obj->total_image_Loading_Speed * 500);
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
                'first_searched_by_date' => Carbon::now(),
                'last_searched_by' => $obj->last_searched_by,
                'last_searched_by_date' => Carbon::now()
            ]);
        }

        $log = new LogsController();
        $log->logAction('searched_website', $searched_website->id, Null);
        return $obj;

    }

    function getImageLinks($url)
    {

        $client = new Client();
        try {
            $response = $client->get($url);

            $pattern = '/https?:\/\/[^\s"]+?\.(?:jpg|jpeg|png|webp|gif)/i';

            $matches = [];
            $responseBody = $response->getBody()->getContents();
            preg_match_all($pattern, $responseBody, $matches);

            $uniqueMatches = array_unique($matches[0]);

            return $uniqueMatches;
        } catch (RequestException $e) {
            if ($e->getResponse() && $e->getResponse()->getStatusCode() == 405) {
                return [];
            } else {
                return $e->getMessage();
            }
        }
    }

    function getImageLinksTest($url)
    {
        $client = new Client();
        $response = $client->get($url);
        $html = $response->getBody()->getContents();

        $crawler = new Crawler($html);

        $imageUrls = $crawler->filter('img')->each(function (Crawler $node) {
            return $node->attr('src');
        });

        $backgroundImageUrls = [];
        $styles = $crawler->filter('style')->each(function (Crawler $node) {
            return $node->text();
        });

        foreach ($styles as $style) {
            $pattern = '/background-image:.*url\((.*?)\)/';
            preg_match_all($pattern, $style, $matches);
            $backgroundImageUrls = array_merge($backgroundImageUrls, $matches[1]);
        }

        $allImageUrls = array_merge($imageUrls, $backgroundImageUrls);

        return $allImageUrls;
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



    protected function calculateLoadingSpeed(array $imageUrls)
    {
        $speed = 10;
        $loadingTimes = [];

        $totalLoadingSpeed = 0;

        foreach ($imageUrls as $url) {
            $headers = get_headers($url, 1);
            $fileSize = isset($headers['Content-Length']) ? $headers['Content-Length'] : null;

            if ($fileSize) {
                $loadingTime = $fileSize / ($speed * 125000);
                $totalLoadingSpeed += round($loadingTime, 3);
                $loadingTimes[] = round($loadingTime, 3);
            }
        }

        return $loadingTimes;
    }

    protected function totalLoadingSpeed(array $loadingSpeeds)
    {
        $total = 0;
        foreach ($loadingSpeeds as $speed) {
            $total += $speed;
        }


        return $total;
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
                if ($extension == "") {
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