<?php

namespace Data\Repository\Concrete;


use Data\Entity\Label;
use Data\Repository\Abst\ILabelRepo;

class LabelRepo implements ILabelRepo
{

    public function orWhere($in, $like, $val)
    {
        return Label::orWhere($in, $like, $val);
    }
    public function get()
    {
        return Label::get();
    }

    public function insert()
    {
        return Label::insert();
    }

    public function where($in, $how, $opt=null)
    {
        return Label::where($in, $how, $opt=null);
    }
}