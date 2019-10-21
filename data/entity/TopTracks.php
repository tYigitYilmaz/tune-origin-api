<?php

namespace Data\Entity;

use \Illuminate\Database\Eloquent\Model;

class TopTracks extends Model
{
    protected $table = "top_tracks";
    protected  $hidden = ['track_id'];
    protected $model;

        public function track(){
        return $this->belongsTo('Data\Entity\Track');


    }

}