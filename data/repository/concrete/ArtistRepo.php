<?php

namespace Data\Repository\Concrete;


use Data\Entity\Artist;
use Data\Repository\Abst\IArtistRepo;

class ArtistRepo implements IArtistRepo
{

    public function where($in, $how, $opt=null)
    {
       return Artist::where($in, $how, $opt=null);
    }

    public function first()
    {
        return Artist::first();
    }

    public function orWhere($in, $like, $val)
    {
        return Artist::orWhere($in, $like, $val);
    }

    public function get()
    {
        return Artist::get();
    }

    public function with(...$val)
    {
        return Artist::with(...$val);
    }

    public function insert()
    {
        return Artist::insert();
    }
}