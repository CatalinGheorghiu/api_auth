<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header("Access-Control-Max-Age: 3600");
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Access-Control-Allow-Origin, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/User.php';


//Instantiate DB & connect
$database = new Database();
$db = $database->connect();

//Instantiate announces post object
$user = new User($db);

// get posted data
$data = json_decode(file_get_contents("php://input"));

// set product property values
$user->email = $data->email;
$email_exists = $user->check_email();
// var_dump($user->email);
// var_dump($email_exists);
// var_dump($data->password);
// var_dump($user->password);

// generate json web token
include_once '../../config/core.php';
include_once '../../libs/vendor/firebase/php-jwt/src/BeforeValidException.php';
include_once '../../libs/vendor/firebase/php-jwt/src/ExpiredException.php';
include_once '../../libs/vendor/firebase/php-jwt/src/SignatureInvalidException.php';
include_once '../../libs/vendor/firebase/php-jwt/src/JWT.php';

use \Firebase\JWT\JWT;

// check if email exists and if password is correct
if ($email_exists && password_verify($data->password, $user->password)) {
    // var_dump($email_exists);
    $token = [
        "iss" => $iss,
        "aud" => $aud,
        "iat" => $iat,
        "nbf" => $nbf,
        "exp" => $exp,
        "data" => [
            "id" => $user->id,
            "name" => $user->name,
            "email" => $user->email
        ]
    ];

    // set response code
    http_response_code(200);

    // generate jwt
    $jwt = JWT::encode($token, $key);
    echo json_encode(
        array(
            "message" => "Successful login.",
            "jwt" => $jwt
        )
    );
} // login failed
else {

    // set response code
    http_response_code(401);

    // tell the user login failed
    echo json_encode(array("message" => "Login failed."));
}
