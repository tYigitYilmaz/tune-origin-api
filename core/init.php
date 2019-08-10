<?php
define ( 'APP_DIR' , BASE_DIR . '/app'. DS);
define ( 'CORE_DIR' , BASE_DIR . '/core'. DS);
define ( 'ROUTE_DIR' , BASE_DIR . '/route'. DS);
define ( 'API_DIR' , BASE_DIR . '/config/api'. DS);

use Core\DB;

/*function __autoload($classname) {
    $filename = $classname . ".php";
    echo $filename;
    if(file_exists( CORE_DIR.$filename ))
    {
        include_once(CORE_DIR.$filename);
    }
}*/

foreach (glob(ROUTE_DIR.'*.php') as $filename)
{

    include_once $filename;
}

$v = new DB();


?>