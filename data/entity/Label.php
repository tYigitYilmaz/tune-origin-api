<?php

namespace Data\Entity;

use \Illuminate\Database\Eloquent\Model;

class Label extends Model
{
    protected $table = "labels";
    protected $visible = ['name'];

    protected $model;


}