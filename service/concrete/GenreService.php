<?php
namespace Service\Concrete;


use Data\Repository\Abst\IGenreRepo;
use Service\Abst\IGenreService;

class GenreService implements IGenreService
{
    public $iGenreRepo;

    public function __construct(IGenreRepo $iGenreRepo)
    {
        $this->iGenreRepo = $iGenreRepo;
    }

    public function index(){
        $arr = $this->iGenreRepo->all();
        echo json_encode($arr);
    }
}