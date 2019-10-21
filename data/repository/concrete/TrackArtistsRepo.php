<?php

namespace Data\Repository\Concrete;

use Data\Entity\TrackArtists;
use Data\Repository\Abst\ITrackArtistsRepo;

class TrackArtistsRepo implements ITrackArtistsRepo
{
    public function insert()
    {
        return TrackArtists::insert();
    }
    public function where($in, $how, $opt=null)
    {
        return TrackArtists::where($in, $how, $opt=null);
    }

}