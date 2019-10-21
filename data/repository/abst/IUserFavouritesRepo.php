<?php

namespace Data\Repository\Abst;


Interface IUserFavouritesRepo
{
    public function insert();
    public function where($in, $how, $opt=null);
}