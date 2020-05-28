<?php
// var_dump($_SERVER['REQUEST_METHOD'], $_GET);


if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    //    GET /{api}/{id}
    if (array_key_exists('id', $_GET)) {
        $filePath = 'api/' . $_GET['resource'] . '/read-single.php';
    }
    //    GET /{api}
    else {
        $filePath = 'api/' . $_GET['resource'] . '/read-many.php';
    }
}
//    POST /{api}
elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $filePath = 'api/' . $_GET['resource'] . '/create.php';
}
//    PUT /{api}/{id}
elseif ($_SERVER['REQUEST_METHOD'] == 'PUT' and array_key_exists('id', $_GET)) {
    $filePath = 'api/' . $_GET['resource'] . '/update.php';
}
//    DELETE /{api}/{id}
elseif ($_SERVER['REQUEST_METHOD'] == 'DELETE' and array_key_exists('id', $_GET)) {
    $filePath = 'api/' . $_GET['resource'] . '/delete.php';
}

if (isset($filePath) and file_exists($filePath)) {
    // include 'config/Database.php';
    // include 'models/Post.php';
    // include 'models/User.php';
    include $filePath;
} else {
    echo 'KO !';
}
