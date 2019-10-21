<?php
namespace App\Controller\Jobs;

use Data\Entity\Artist;
use Data\Entity\Label;
use Data\Entity\Track;
use Data\Repository\Abst\IArtistRepo;
use Data\Repository\Abst\IGenreRepo;
use Data\Repository\Abst\ILabelRepo;
use Data\Repository\Abst\ITopTracksRepo;
use Data\Repository\Abst\ITrackArtistsRepo;
use Data\Repository\Abst\ITrackRepo;
use Data\Repository\Abst\IUserFavouritesRepo;
use DOMDocument;
use Illuminate\Support\Carbon;


class TrackParser {

private const BASE_URL = "https://www.beatport.com";
protected $genres;
protected static $topTracksArr = array();
protected static $trackArtistArr = array();

    public $iTrackRepo;
    public $iUserFavouritesRepo;
    public $iArtistRepo;
    public $iGenreRepo;
    public $iLabelRepo;
    public $iToptracksRepo;
    public $iTrackArtistsRepo;

    public function __construct(
        ITrackRepo $iTrackRepo,
        IUserFavouritesRepo $iUserFavouritesRepo,
        IArtistRepo $iArtistRepo,
        iGenreRepo $iGenreRepo,
        ILabelRepo $iLabelRepo,
        ITopTracksRepo $iToptracksRepo,
        ITrackArtistsRepo $iTrackArtistsRepo
    )
    {
        $this->iTrackRepo = $iTrackRepo;
        $this->iUserFavouritesRepo = $iUserFavouritesRepo;
        $this->iArtistRepo = $iArtistRepo;
        $this->iGenreRepo = $iGenreRepo;
        $this->iLabelRepo = $iLabelRepo;
        $this->iToptracksRepo = $iToptracksRepo;
        $this->iTrackArtistsRepo = $iTrackArtistsRepo;
        $this->parse();
    }

    public function parse(){
        foreach ($this->genres as $genre){
            $this->curlUrl(self::BASE_URL.$genre->url, $genre->id);
        }
        $this->iToptracksRepo->insert(self::$topTracksArr);
        $this->iTrackArtistsRepo->insert(self::$trackArtistArr);

    //    logTime('parse called');
    }

    public function curlUrl($url,$genre_id){
    //    logTime('curlUrl'.$url);
        $ch = curl_init();
        $timeout = 5;
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        $html = curl_exec($ch);
        curl_close($ch);

    # Create a DOM parser object
        $dom = new DOMDocument();

    # Parse the HTML from Google.
    # The @ before the method call suppresses any warnings that
    # loadHTML might throw because of invalid HTML in the page.
        @$dom->loadHTML($html);

        $trackul = null;
    # Iterate over all the <a> tags

    # Iterate over all the <a> tags
        foreach ($dom->getElementsByTagName('script') as $script) {
            if ($script->getAttribute("id") == "data-objects") {
                $trackul = $script;
                break;
            }
        }

        $trackulStr = substr(strstr($trackul->nodeValue, '{'), strlen('{') - 1);
        $trackulStr = substr($trackulStr, 0, strpos($trackulStr, ";"));
        $jsonArray = json_decode($trackulStr, true);
        $this->match($jsonArray, $genre_id);

    }

    function match($jsonArray, $genre_id){
        foreach ($jsonArray as $key => $value) {
            if ($key == "tracks" && is_array($value)) {
                $len = count($value);

                for ($i = 0; $i < $len; $i++) {
    //                logTime('label saving started '.PHP_EOL);
                    $label_bid = $value[$i]["label"]["id"];
                    $labelObj = $this->iLabelRepo->where('bid', $label_bid)->first();

                    if (is_null($labelObj)) {
                        $labelObj = new Label();
                        $labelObj->bid = $label_bid;
                        $labelObj->name = $value[$i]["label"]["name"];
                        $labelObj->save();
                    }

                    $label_id = $labelObj->id;

                    $track_bid = $value[$i]["id"];
                    $trackObj = $this->iTrackRepo->where('bid',$track_bid)->first();

    //                logTime('artist saving'.PHP_EOL);
                    foreach ( $value[$i]["artists"] as $artist){
                        $artist_bid = $artist["id"];
                        $artistObj = $this->iArtistRepo->where('bid', $artist_bid)->first();

                        if (is_null($artistObj)) {
                            $artistObj = new Artist();
                            $artistObj->bid = $artist_bid;
                            $artistObj->name = $artist["name"];
                            $artistObj->save();
                        }
                        $artist_id = $artistObj->id;

    //                logTime('track saving'.PHP_EOL);

                    if (is_null($trackObj)){
                        $trackObj = new Track();
                        $trackObj->name= $value[$i]["name"];
                        $trackObj->bpm = $value[$i]["bpm"];
                        $trackObj->bid = $track_bid;
                        $trackObj->mix = $value[$i]["mix"];
                        $trackObj->length = $value[$i]["duration"]["minutes"];
                        $trackObj->release_date = $value[$i]["date"]["released"];
                        $trackObj->bikey = $value[$i]["key"];

                        $url = $value[$i]["images"]["large"]["url"];
                        $extension = pathinfo(parse_url($url, PHP_URL_PATH), PATHINFO_EXTENSION);
                        $img = BASE_DIR.'/uploads/img/'.bin2hex(openssl_random_pseudo_bytes(8)).".".$extension;

                        if (!file_exists($img)){
                            file_put_contents($img, file_get_contents($url));
                        }

                        $trackObj->img_url = $img;
                        $trackObj->label_id = $label_id;
                        $trackObj->genre_id = $genre_id;

                        $str = $artistObj->name.' - '.$trackObj->name.' ('.$trackObj->mix.')';
//                        vd($str);
//                        $youtube_link = new YoutubeController();
//                        $trackObj->youtube_url = $youtube_link->youtubeSearch($str);


                        $trackObj->save();
                    }
                    $track_id = $trackObj->id;

                        $trackArtistsObj = $this->iTrackArtistsRepo->where('artist_id',$artist_id)->where('track_id',$track_id)->first();

                        if (is_null($trackArtistsObj)){
                            $arr = [
                                'artist_id' => $artist_id,
                                'track_id' => $track_id,
                                'created_at' => Carbon::now(),
                            ];
                            self::$trackArtistArr[] = $arr;
                        }
                    }

                    $topTrackObj = $this->iToptracksRepo->where('genre_id', $genre_id)->where('track_id', $track_id)->where('order', ($i+1))->whereDate('created_at', '=', date('Y-m-d'))->first();

                    if (is_null($topTrackObj)){
                        $arr = [
                            'genre_id' => $genre_id,
                            'track_id' => $track_id,
                            'order' => ($i+1),
                            'created_at' => Carbon::now(),
                            'img_url' => '',
                        ];
                        if ($i==0){
                              $arr['img_url'] = $trackObj->img_url;
                        }
                        self::$topTracksArr[]=$arr; //Batch insert'in array kabul etmesinden oturu.
                    }
                }
            }
        }
    }
}

?>
