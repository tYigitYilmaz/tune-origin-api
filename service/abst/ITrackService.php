<?php

namespace Service\Abst;


interface ITrackService  {

    public function getTracks();
    public function getTrack($id);
    public function topTracks($genre_id);
    public function getFavouriteTracks();
    public function favouriteTrack();
    public function deleteFavouriteTrack();
    public function search();
}