<?php
//Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header("Access-Control-Max-Age: 3600");
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Access-Control-Allow-Origin, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once 'config/Database.php';
include_once 'models/User.php';


//Instantiate DB & connect
$database = new Database();
$db = $database->connect();

//Instantiate announces post object
$user = new User($db);

//Get raw posted data
$data = json_decode(file_get_contents("php://input"));
// var_dump($data);

$user->name = $data->name;
$user->email = $data->email;
$user->password = $data->password;

$email_data = $user->check_email();

if (!empty($email_data)) {
    //Means email already exists
    echo json_encode(
        [
            'message' => 'Email already exists'
        ]
    );
} else {
    //Create User
    if (!empty($user->name) && !empty($user->email) && !empty($user->password) && $user->create()) {
        // set response code
        http_response_code(200);

        echo json_encode(
            [
                'message' => 'User created'
            ]
        );
    } else {

        // set response code
        http_response_code(400);

        echo json_encode(
            [
                'message' => 'User not created'
            ]
        );
    }
}

// //Create User
// if ($user->create()) {
//     echo json_encode(
//         [
//             'message' => 'User created'
//         ]
//     );
// } else {
//     echo json_encode(
//         [
//             'message' => 'User not created'
//         ]
//     );
// }


























//  /resources/users/read-one.php

// $dbh = new PDO(
//     'mysql:host=localhost;dbname=BlogZen;charset=utf8',
//     'root',
//     '',
//     [
//         PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
//         PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
//     ]
// );

// $query = '  INSERT INTO 
//                 Users (email, password, name) 
//             VALUES (:email, :password, :name)';

// $sth = $dbh->prepare($query);
// $sth->bindValue(':email', $_POST['email'], PDO::PARAM_STR);
// $sth->bindValue(':password', $_POST['password'], PDO::PARAM_STR);
// $sth->bindValue(':name', $_POST['name'], PDO::PARAM_STR);
// $sth->execute();
// $user = [
//     'id' => $dbh->lastInsertId(),
//     'email' => $_POST['email'],
//     'name' => $_POST['name']
// ];


// header($_SERVER['SERVER_PROTOCOL'] . ' 200 OK');
// header('Content-Type: application/json');
// echo json_encode($user);
// exit;

// if (!array_key_exists('email', $_POST) or !array_key_exists('password', $_POST)) {
//     header($_SERVER['SERVER_PROTOCOL'] . ' 409 Conflict');
//     header('Content-Type: application/json');
//     echo json_encode(['message' => 'Champ(s) manquant(s)']);
//     exit;
// }

// $email = trim($_POST['email']);
// $password = trim($_POST['password']);

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
//     SELECT
//         COUNT(*) > 0
//     FROM
//         Users
//     WHERE
//         email = :email
// ';
// $sth = $dbh->prepare($query);
// $sth->bindValue(':email', $email, PDO::PARAM_STR);
// $sth->execute();
// $alreadyExistingEmail = boolval($sth->fetchColumn());

// if ($alreadyExistingEmail) {
//     header($_SERVER['SERVER_PROTOCOL'] . ' 409 Conflict');
//     header('Content-Type: application/json');
//     echo json_encode(['message' => 'Adresse électronique déjà existante']);
//     exit;
// }

// $query =
//     '
//         INSERT INTO
//             Users
//             (email, password)
//         VALUES
//             (:email, :password)
//     ';
// $sth = $dbh->prepare($query);
// $sth->bindValue(':email', $email, PDO::PARAM_STR);
// $sth->bindValue(':password', password_hash($password, PASSWORD_BCRYPT), PDO::PARAM_STR);
// $sth->execute();

// $user =
//     [
//         'id' => $dbh->lastInsertId(),
//         'email' => $email
//     ];

// header($_SERVER['SERVER_PROTOCOL'] . ' 201 Created');
// header('Content-Type: application/json');
// echo json_encode($user);
// exit;
