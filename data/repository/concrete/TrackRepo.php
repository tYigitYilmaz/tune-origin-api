<?php

namespace Data\Repository\Concrete;



use Data\Repository\Abst\ITrackRepo;
use Data\Entity\Track;

class TrackRepo implements ITrackRepo
{
    public function where($in, $how, $opt=null)
    {
        return Track::where($in, $how, $opt=null);
    }

    public function first()
    {
        return Track::first();
    }

    public function orWhere($in, $like, $val)
    {
        return Track::orWhere($in, $like, $val);
    }

    public function get()
    {
        return Track::get();
    }

    public function with(...$val)
    {
        return Track::with(...$val);
    }

    public function insert()
    {
        return Track::insert();
    }
}