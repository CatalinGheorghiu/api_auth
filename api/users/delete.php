<?php //  /resources/users/delete-one.php
//Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once 'config/Database.php';
include_once 'models/User.php';


//Instantiate DB & connect
$database = new Database();
$db = $database->connect();

//Instantiate user object
$user = new User($db);

//Get raw user data
$data = json_decode(file_get_contents("php://input"));

//Set id to delete
$user->id = $data->id;

//Delete user
if ($user->delete()) {
    echo json_encode(
        [
            'message' => 'User deleted'
        ]
    );
} else {
    echo json_encode(
        [
            'message' => 'User not deleted'
        ]
    );
}
























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
//         DELETE FROM
//             Users
//         WHERE
//             id = :id
//     ';

// $sth = $dbh->prepare($query);
// $sth->bindValue(':id', $_GET['id'], PDO::PARAM_INT);
// $sth->execute();

// if ($sth->rowCount() == 0) {
//     header($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found');
//     header('Content-Type: application/json');
//     echo json_encode(['message' => 'Utilisateur inexistant']);
//     exit;
// }

// header($_SERVER['SERVER_PROTOCOL'] . ' 204 No Content');
// exit;
