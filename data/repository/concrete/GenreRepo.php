<?php

namespace Data\Repository\Concrete;

use Data\Entity\Genre;
use Data\Repository\Abst\IGenreRepo;

class GenreRepo implements IGenreRepo
{

    public function all()
    {
      return Genre::all();
    }

    public function orWhere($in, $like, $val)
    {
        return Genre::orWhere($in, $like, $val);
    }

    public function get()
    {
        return Genre::get();
    }

    public function insert()
    {
        return Genre::insert();
    }
}