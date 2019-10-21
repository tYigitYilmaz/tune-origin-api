<?php

namespace Data\Entity;

use \Illuminate\Database\Eloquent\Model;

class Track extends Model
{
    protected $table = "tracks";
//    protected $visible = ['name','release_date','mix','artist'];
    protected $hidden = ['bid','artist_id','label_id','genre_id','img_url','created_at','updated_at','deleted_at'];

    public function artist(){
    return $this->belongsToMany('Data\Entity\Artist', 'track_artists', 'track_id' , 'artist_id');
}

    public function label(){
        return $this->belongsTo('Data\Entity\Label');
    }

    public function genre(){
        return $this->belongsTo('Data\Entity\Genre');
    }
}