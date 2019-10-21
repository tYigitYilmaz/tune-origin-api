<?php

function vd($var){
    echo "<pre>";
    var_dump($var);
}

function dd($var){
    echo "<pre>";
    var_dump($var);
    die;
}

$start_time =  microtime(true);


function logTime($message){
    global $start_time;
    $end_time = microtime(true);
    echo "<br>";
    echo ": =>".($end_time -$start_time)."<="."<br>". $message;
    $start_time = $end_time;
}

?>