<?php

namespace Data\Repository\Abst;

Interface IArtistRepo
{
    public function where($in, $how, $opt=null);
    public function orWhere($in, $like, $val);
    public function get();
    public function first();
    public function insert();
    public function with(...$val);

}