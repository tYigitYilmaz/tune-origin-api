<?php

namespace Data\Entity;

use Illuminate\Database\Eloquent\Model;

class TrackArtists extends Model
{
    public $table_name = "track_artists";
    public $timestamps = false;
    protected $model;

}