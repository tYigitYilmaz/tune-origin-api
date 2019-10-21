<?php
namespace App\Controller;


use Service\Abst\IGenreService;

class GenreController extends ProtectedController {

     private $iGenreService;

    public function __construct(IGenreService $iGenreService)
    {
        $this->iGenreService =$iGenreService;
    }

    public function index(){
        $this->iGenreService->index();
    }
}