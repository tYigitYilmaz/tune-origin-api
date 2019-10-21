<?php

namespace Data\Repository\Abst;


interface IGenreRepo
{
    public function all();
    public function orWhere($in, $like, $val);
    public function get();
    public function insert();


}