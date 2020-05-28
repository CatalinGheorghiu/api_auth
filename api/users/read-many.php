<?php
//Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once 'config/Database.php';
include_once 'models/User.php';

//Instantiate DB & connect
$database = new Database();
$db = $database->connect();

//Instantiate announces post object
$users = new User($db);

//Call the method
$result = $users->read();

//Get row count
$num = $result->rowCount();

//Check if any users
if ($num > 0) {
    //Users array
    $users_arr = [];
    $users_arr['data'] = [];

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $users_item = [
            'id' => $id,
            'email' => $email,
            'name' => $name
        ];

        //Push to "data"
        array_push($users_arr['data'], $users_item);
    }

    //Turn to JSON & output
    echo json_encode($users_arr);
} else {
    //No posts
    echo json_encode(
        [
            'message' => 'No post found'
        ]
    );
}
