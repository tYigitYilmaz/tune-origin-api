<?php

namespace App\Controller;

use Service\Abst\IImageService;

class ImageController
{
    public $iImageservice;


    /**
     * ImageController constructor.
     */
    public function __construct(IImageService $iImageservice)
    {
        $this->iImageService = $iImageservice;
    }

    public function returnImg($hashed_name){
        $this->iImageService->returnImg($hashed_name);
    }
}