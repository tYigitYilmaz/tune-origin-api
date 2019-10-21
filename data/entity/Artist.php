<?php

namespace Data\Entity;

use \Illuminate\Database\Eloquent\Model;

class Artist extends Model
{
    protected $table = "artists";
    protected $visible = ['name'];
    protected $model;

}