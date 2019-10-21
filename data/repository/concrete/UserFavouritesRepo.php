<?php

namespace Data\Repository\Concrete;

use Data\Repository\Abst\IUserFavouritesRepo;

class UserFavouritesRepo implements IUserFavouritesRepo
{

    public function insert()
    {
        return UserFavouritesRepo::insert();
    }

    public function where($in, $how, $opt=null)
    {
        return UserFavouritesRepo::where($in, $how, $opt=null);
    }
}