<?php
namespace Service\Concrete;


use Exception;
use GuzzleHttp\Client;
use Service\Abst\IYoutubeService;

class YoutubeService implements IYoutubeService
{

   public function youtubeSearch($search){

        global $core_var;
        require_once "vendor/autoload.php";
        try {
            $client = new Client([
                // Base URI is used with relative requests
                'base_uri' => 'https://www.googleapis.com/youtube/v3/',
            ]);

            $response = $client->request('GET', 'search', [
                'query' => [
                    'part' => 'snippet',
                    'order' => 'viewCount', //YouTube video id
                    'q' => $search,
                    'type' => 'video',
                    'key' => $core_var['api'],
                ],
                'verify' => false,
            ]);

            if($response->getStatusCode() == 200) {
                $body = $response->getBody();
                $arr_body = json_decode($body);
                dd($arr_body->items[0]->id->videoId);
                return $arr_body->items[0]->id->videoId;

//                $response = new Response(true,[],[$return],200);
//                $response->send();
//                exit();
            }
        } catch(Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}