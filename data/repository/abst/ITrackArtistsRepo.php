<?php

namespace Data\Repository\Abst;



Interface ITrackArtistsRepo
{
    public function insert();
    public function where($in, $how, $opt=null);

}