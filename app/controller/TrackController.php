<?php
namespace App\Controller;

use Core\Model\Response;
use Illuminate\Support\Carbon;
use Service\Abst\ITrackService;

class TrackController extends ProtectedController {

    public $iTrackService;

    public function __construct(ITrackService $iTrackService){
        $this->iTrackService = $iTrackService;
    }


    public function getTracks(){
        $this->iTrackService->getTracks();
    }
    public function getTrack($id){
        $this->iTrackService->getTrack($id);
    }

    public function topTracks($genre_id){
        $this->iTrackService->topTracks($genre_id);
    }

    public function getFavouriteTracks(){
        $this->iTrackService->getFavouriteTracks();
    }

    public function favouriteTrack(){
        $this->iTrackService->favouriteTrack();
    }

    public function deleteFavouriteTrack(){
        $this->iTrackService->deleteFavouriteTrack();
    }

    public function search(){
        $this->iTrackService->search();
    }
}