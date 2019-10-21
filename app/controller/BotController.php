<?php
namespace App\Controller;


use App\Controller\Jobs\TrackParser;

class BotController extends MainController {


    public function index(){

        $trackParser = new TrackParser();

    }

}