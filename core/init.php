<?php


use Core\IOC\Kernel;

define ( 'APP_DIR' , BASE_DIR . '/app'. DS);
define ( 'CORE_DIR' , BASE_DIR . '/core'. DS);
define ( 'ROUTE_DIR' , BASE_DIR . '/route'. DS);
define ( 'CONFIG_DIR' , CORE_DIR . '/config'. DS);
include_once (CORE_DIR.'helper.php');

//get env
$dotenv = Dotenv\Dotenv::create(BASE_DIR);
$dotenv->load();

$kernel = (new Kernel())->boot();

foreach (glob(CONFIG_DIR.'*.php') as $filename)
{
    include_once $filename;
}

$DB = new \Core\DB();

foreach (glob(ROUTE_DIR.'*.php') as $filename)
{
    include_once $filename;
}






?>