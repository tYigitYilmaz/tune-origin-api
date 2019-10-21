<?php

namespace Data\Repository\Concrete;

use Data\Entity\TopTracks;
use Data\Repository\Abst\ITopTracksRepo;

class TopTracksRepo implements ITopTracksRepo
{
    public function insert()
    {
        return TopTracks::insert();
    }

    public function where($in, $how, $opt=null)
    {
        return TopTracks::where($in, $how, $opt=null);
    }
}