<?php //  /resources/users/read-one.php
//Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
include_once 'config/Database.php';
include_once 'models/User.php';

//Instantiate DB
$database = new Database();
$db = $database->connect();

//Instantiate user object
$user = new User($db);

//Get ID
$user->id = isset($_GET['id']) ? $_GET['id'] : die();

//Get User
$user->read_single();

//Create array
$user_arr = [
    'id' => $user->id,
    'name' => $user->name,
    'email' => $user->email
];

//Make Json
print_r(json_encode($user_arr));
























// //Instantiate DB & connect
// $database = new Database();
// $db = $database->connect();

// $query =
//     '   SELECT
//             id,
//             email
//         FROM
//             Users
//         WHERE
//             id = :id
//     ';

// $sth = $db->prepare($query);
// $sth->bindValue(':id', $_GET['id'], PDO::PARAM_INT);
// $sth->execute();
// $user = $sth->fetch();

// if ($user === false) {
//     header($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found');
//     header('Content-Type: application/json');
//     echo json_encode(['message' => 'Utilisateur inexistant']);
//     exit;
// }

// header($_SERVER['SERVER_PROTOCOL'] . ' 200 OK');
// header('Content-Type: application/json');
// echo json_encode($user);
// exit;
