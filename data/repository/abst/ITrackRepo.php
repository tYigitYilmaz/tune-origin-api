<?php

namespace Data\Repository\Abst;



Interface ITrackRepo
{
    public function where($in, $how, $opt=null);
    public function orWhere($in, $like, $val);
    public function get();
    public function first();
    public function with(...$val);
    public function insert();

}