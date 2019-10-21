<?php

namespace Data\Entity;

use \Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Genre extends Model
{
    use SoftDeletes;
    protected $visible = ['id','name'];
    protected $model;

}