<?php //  /resources/users/update-one.php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: PUT");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// files for decoding jwt will be here
include_once 'config/Database.php';
include_once 'models/User.php';

// files for decoding jwt 
include_once 'config/core.php';
include_once 'libs/vendor/firebase/php-jwt/src/BeforeValidException.php';
include_once 'libs/vendor/firebase/php-jwt/src/ExpiredException.php';
include_once 'libs/vendor/firebase/php-jwt/src/SignatureInvalidException.php';
include_once 'libs/vendor/firebase/php-jwt/src/JWT.php';

use \Firebase\JWT\JWT;

//Instantiate DB & connect
$database = new Database();
$db = $database->connect();

//Instantiate DB & connect
$user = new User($db);

//Get raw posted data
$data = json_decode((file_get_contents('php://input')));

// get jwt
$jwt = isset($data->jwt) ? $data->jwt : "";

// if jwt is not empty
if ($jwt) {
    // if decode succeed, show user details
    try {
        // decode jwt
        $decoded = JWT::decode($jwt, $key, array('HS256'));
        // set user property values here
    } catch (Exception $e) {
        // set response code
        http_response_code(401);

        // show error message
        echo json_encode(array(
            "message" => "Access denied.",
            "error" => $e->getMessage()
        ));
    }
} else {
    // show error message if jwt is empty
    // set response code
    http_response_code(401);

    // tell the user access denied
    echo json_encode(array("message" => "Access denied."));
}

//Set ID to update
// $user->id = $data->id;
$user->id = $decoded->data->id;
$user->name = $data->name;
$user->email = $data->email;
$user->password = $data->password;

//Update User
if ($user->update()) {
    // we need to re-generate jwt because user details might be different
    $token = array(
        "iss" => $iss,
        "aud" => $aud,
        "iat" => $iat,
        "nbf" => $nbf,
        "data" => array(
            "id" => $user->id,
            "name" => $user->name,
            "email" => $user->email
        )
    );
    $jwt = JWT::encode($token, $key);

    // set response code
    http_response_code(200);

    // response in json format
    echo json_encode(
        array(
            "message" => "User was updated.",
            "jwt" => $jwt
        )
    );
} else {
    // set response code
    http_response_code(401);
    //Show error message
    echo json_encode(
        [
            'message' => 'User Not Updated'
        ]
    );
}



































// parse_str(file_get_contents('php://input'), $dataReceived);

// if (!array_key_exists('email', $dataReceived) or !array_key_exists('password', $dataReceived)) {
//     header($_SERVER['SERVER_PROTOCOL'] . ' 409 Conflict');
//     header('Content-Type: application/json');
//     echo json_encode(['message' => 'Champ(s) manquant(s)']);
//     exit;
// }

// $email = trim($dataReceived['email']);
// $password = trim($dataReceived['password']);

// if (empty($email) or empty($password)) {
//     header($_SERVER['SERVER_PROTOCOL'] . ' 409 Conflict');
//     header('Content-Type: application/json');
//     echo json_encode(['message' => 'Champ(s) vide(s)']);
//     exit;
// }

// if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
//     header($_SERVER['SERVER_PROTOCOL'] . ' 409 Conflict');
//     header('Content-Type: application/json');
//     echo json_encode(['message' => 'Adresse électronique non valide']);
//     exit;
// }

// $dbh = new PDO(
//     'mysql:host=localhost;dbname=Le_pire_coin;charset=utf8',
//     'root',
//     '',
//     [
//         PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
//         PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
//     ]
// );

// $query =
//     '
//         UPDATE
//             Users
//         SET
//             email = :email,
//             hashedPassword = :hashedPassword
//         WHERE
//             id = :id
//     ';
// $sth = $dbh->prepare($query);
// $sth->bindValue(':email', $email, PDO::PARAM_STR);
// $sth->bindValue(':hashedPassword', password_hash($password, PASSWORD_BCRYPT), PDO::PARAM_STR);
// $sth->bindValue(':id', $_GET['id'], PDO::PARAM_INT);
// $sth->execute();

// if ($sth->rowCount() == 0) {
//     header($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found');
//     header('Content-Type: application/json');
//     echo json_encode(['message' => 'Utilisateur inexistant']);
//     exit;
// }

// $user =
//     [
//         'id' => $_GET['id'],
//         'email' => $email
//     ];

// header($_SERVER['SERVER_PROTOCOL'] . ' 200 OK');
// header('Content-Type: application/json');
// echo json_encode($user);
// exit;
