<?php
namespace Service\Concrete;


use Core\Model\Response;
use Firebase\JWT\JWT;
use Illuminate\Support\Carbon;
use Service\Abst\IAuthService;

class AuthService implements IAuthService
{

    public function register()
    {
        $data = json_decode(file_get_contents("php://input"));

        $user = ([
            'firstname' => htmlspecialchars($data->firstname),
            'lastname' => htmlspecialchars($data->lastname),
            'email' => htmlspecialchars($data->email),
            'password' => password_hash($data->password, PASSWORD_BCRYPT),
            'created_at' => Carbon::now(),
        ]);

        if (is_null(User::where('email',$data->email)->first())) {

            User::insert($user);
            $response = new Response(true,"User was created.", [],200 );
            $response->send();
        } else {
            $response = new Response(true,"Unable to create user.", [],400 );
            $response->send();
        }
    }

    public function login()
    {
        global $core_var;
        $data = json_decode(file_get_contents("php://input"));

        $user = User::where('email',$data->email)->first();
        if (!is_null($user) && password_verify($data->password, $user->password)) {
            $token = array(
                "iss" => $core_var["iss"],
                "aud" => $core_var["aud"],
                "iat" => $core_var["iat"],
                "nbf" => $core_var["nbf"],
                "data" => array(
                    "id" => $user->id,
                    "firstname" => $user->firstname,
                    "lastname" => $user->lastname,
                    "email" => $user->email
                )
            );

            $jwt = JWT::encode($token, $core_var["key"]);
            $data_resp = ['jwt'=> $jwt,'email'=>$user->email];

            $response = new Response(true,"Successful login.", $data_resp,200 );
            $response->send();

        } else {

            $response = new Response(true,"Login failed.", [],401 );
            $response->send();
        }
    }
}