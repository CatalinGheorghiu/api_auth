<?php
//Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once 'config/Database.php';
include_once 'models/Post.php';


//Instantiate DB & connect
$database = new Database();
$db = $database->connect();

//Instantiate announces post object
$post = new Post($db);

//Announce post query
$result = $post->read();
//Get row count
$num = $result->rowCount();


//Check if any post
if ($num > 0) {
    //Post array
    $posts_arr = [];
    $posts_arr['data'] = [];

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        
        $post_item = [
            'id' => $id,
            'title' => $title,
            'location' => $location,
            'price' => $price,
            'name' => $name,
            'user_id' => $user_id,
            'creation_time' => $creation_time,
            'img_url' => $img_url,

        ];
        //Push to "data
        array_push($posts_arr['data'], $post_item);
    }

    //Turn to JSON & output
    echo json_encode($posts_arr);
} else {
    //No posts
    echo json_encode(
        [
            'message' => 'No post found'
        ]
    );
}
