<?php

namespace Data\Repository\Abst;



interface ITopTracksRepo
{
    public function insert();
    public function where($in, $how, $opt=null);

}