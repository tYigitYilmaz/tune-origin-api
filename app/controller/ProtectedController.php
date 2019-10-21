<?php

namespace App\Controller;

use Core\Model\Response;
use Exception;
use Firebase\JWT\JWT;

class ProtectedController extends MainController
{

    public function __construct()
    {
        $this->jwtControl();
    }

    function jwtControl(){
        global $core_var;

        $data = json_decode(file_get_contents("php://input"));
        $jwt=isset($data->jwt) ? $data->jwt : "";

        if($jwt){
            try {
                $decoded = JWT::decode($jwt, $core_var["key"], array('HS256'));
            }
            catch (Exception $e){
                $response = new Response(true, "Access denied.",[], 401);
                $response->send();
                exit();
            }
        }
        else{
            $response = new Response(true, "Access denied.", [], 401);
            $response->send();
            exit();
        }
    }
}