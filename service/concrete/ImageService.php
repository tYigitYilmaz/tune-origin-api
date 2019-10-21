<?php
namespace Service\Concrete;


use Service\Abst\IImageService;

class ImageService implements IImageService
{


    public function returnImg($hashed_name){
        $img = BASE_DIR.'/uploads/img/'.$hashed_name.".".'jpg';
        $type = 'image/jpeg';
        header('Content-Type:'.$type);
        header('Content-Length: ' . filesize($img));
        readfile($img);
    }
}