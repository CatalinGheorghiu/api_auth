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

//Get ID
$post->id = isset($_GET['id']) ? $_GET['id'] : die();

//Get post
$post->read_single();

//Create array 
$post_arr = [
    'id' => $post->id,
    'title' => $post->title,
    'location' => $post->location,
    'price' => $post->price,
    'img_url' => $post->img,
    'phone_number' => $post->phone_number,
    'name' => $post->name,
    'email' => $post->email,
    'user_id' => $post->user_id,
    'creation_time' => $post->creation_time,
    'mileage' => $post->mileage,
    'power' => $post->power,
    'fuel' => $post->fuel,
    'registration_date' => $post->registration_date,
    'cubic_capacity' => $post->cubic_capacity,
];

//Make JSON
print_r(json_encode($post_arr));
