<?php
namespace Service\Concrete;

use App\Controller\ProtectedController;
use Core\Model\Response;
use Data\Repository\Abst\IArtistRepo;
use Data\Repository\Abst\IGenreRepo;
use Data\Repository\Abst\ILabelRepo;
use Data\Repository\Abst\ITrackRepo;
use Data\Repository\Abst\IUserFavouritesRepo;
use Data\Repository\Abst\IUserRepo;
use Illuminate\Support\Carbon;
use Service\Abst\ITrackService;

class TrackService implements ITrackService
{
    public $iTrackRepo;
    public $iUserFavouritesRepo;
    public $iArtistRepo;
    public $iGenreRepo;
    public $iLabelRepo;

    public function __construct(
        ITrackRepo $iTrackRepo,
        IUserFavouritesRepo $iUserFavouritesRepo,
        IArtistRepo $iArtistRepo,
        iGenreRepo $iGenreRepo,
        iLabelRepo $iLabelRepo
    )
    {
        $this->iTrackRepo = $iTrackRepo;
        $this->iUserFavouritesRepo = $iUserFavouritesRepo;
        $this->iArtistRepo = $iArtistRepo;
        $this->iGenreRepo = $iGenreRepo;
        $this->iLabelRepo = $iLabelRepo;
    }

    public function getTracks(){ // show($genre_id)
        $tracks = $this->iTrackRepo->with('artist','label','genre')->get();
        $result = $tracks->iTrackRepo->toJson(JSON_INVALID_UTF8_IGNORE |JSON_UNESCAPED_LINE_TERMINATORS);
        $response = new Response( true,[],$result,200);
        $response->send();
    }

    public function getTrack($id){ // show($genre_id)
        $tracks = $this->iTrackRepo->where('id', $id)->with('artist','label','genre')->get();

        $result = $tracks->toJson(JSON_INVALID_UTF8_IGNORE |JSON_UNESCAPED_LINE_TERMINATORS);
        $response = new Response( true,[],$result,200);
        $response->send();
    }

    public function topTracks($genre_id){
        $tracks = $this->iTrackRepo->where('genre_id', $genre_id)->with('track', 'track.artist', 'track.label', 'track.genre')->get();
        $result = $tracks->toJson(JSON_INVALID_UTF8_IGNORE |JSON_UNESCAPED_LINE_TERMINATORS);
        $response = new Response( true,[],$result,200);
        $response->send();
    }

    public function getFavouriteTracks(){
        $data = json_decode(file_get_contents("php://input"));

        $tracks = $this->iUserFavouritesRepo->where('user_id', $data->id)->with('track')->get();
        $result = $tracks->toJson(JSON_INVALID_UTF8_IGNORE |JSON_UNESCAPED_LINE_TERMINATORS);
        $response = new Response( true,[],$result,200);
        $response->send();
    }

    public function favouriteTrack(){
        $data = json_decode(file_get_contents("php://input"));

        $favouriteTrack = [
            'track_id' => $data->track_id,
            'user_id'  => $data->id,
            'created_at' => Carbon::now(),
        ];
        $this->iUserFavouritesRepo->insert($favouriteTrack);
        $response = new Response( true,["Track is included in the favourite list.."],[],200);
        $response->send();
    }

    public function deleteFavouriteTrack(){
        $data = json_decode(file_get_contents("php://input"));

        $deleteTrack = $this->iUserFavouritesRepo->where('user_id',$data->id)->where('track_id',$data->track_id)->delete();
        $response = new Response( true,["Track is deleted from the favourite list.."],[],200);
        $response->send();
    }

    public function search(){ // show($id)
        $data = json_decode(file_get_contents("php://input"));
        $tracks = $this->iTrackRepo->with('artist','label','genre')->orWhere('name', 'like', '%' . $data->querystring . '%')->get();
        $artists = $this->iArtistRepo->orWhere('name', 'like', '%' . $data->querystring . '%')->get();
        $genres = $this->iGenreRepo->orWhere('name', 'like', '%' . $data->querystring . '%')->get();
        $labels = $this->iLabelRepo->orWhere('name', 'like', '%' . $data->querystring . '%')->get();

        $track = $tracks->toJson(JSON_INVALID_UTF8_IGNORE |JSON_UNESCAPED_LINE_TERMINATORS);
        $artist = $artists->toJson(JSON_INVALID_UTF8_IGNORE |JSON_UNESCAPED_LINE_TERMINATORS);
        $genre = $genres->toJson(JSON_INVALID_UTF8_IGNORE |JSON_UNESCAPED_LINE_TERMINATORS);
        $label = $labels->toJson(JSON_INVALID_UTF8_IGNORE |JSON_UNESCAPED_LINE_TERMINATORS);

        $result = [
            'Tracks' => $track,
            'Artists' => $artist,
            'Genres' => $genre,
            'Labels' => $label,];

        $response = new Response( true,[],$result,200);
        $response->send();
    }
}