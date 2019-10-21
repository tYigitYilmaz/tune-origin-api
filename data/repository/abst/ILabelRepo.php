<?php

namespace Data\Repository\Abst;


interface ILabelRepo
{
    public function orWhere($in, $like, $val);
    public function get();
    public function insert();
    public function where($in, $how, $opt=null);


}