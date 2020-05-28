<?php
// show error reporting
error_reporting(E_ALL);

// set your default time-zone
date_default_timezone_set('Europe/Paris');

// variables used for jwt
$iss = "localhost";
$iat = time();
$nbf = $iat + 10;
$exp = $iat + 30;
$aud = "myusers";
$key = "owt125";
