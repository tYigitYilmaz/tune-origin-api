<?php
namespace Data\Entity;

use \Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserFavourites extends Model
{
    protected $table = "user_favourites";
    use SoftDeletes;
    protected $model;


    public function track(){
        return $this->belongsTo('Data\Entity\Track');
    }


}