<?php
header("Access-Control-Allow-Origin: *");

$postdata = file_get_contents("php://input");
$request = json_decode($postdata);

$email = $request->email;
$password = $request->password;
$lat= $request->lat;
$lng= $request->lng;
?>