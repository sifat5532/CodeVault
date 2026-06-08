<?php
session_start();
header("Content-Type: application/json");
if(!isset($_SESSION["id"])){
    echo json_encode(["status" => false]);
    exit();
}
require "config.php";

$user_id = $_SESSION["id"];

$input = json_decode(file_get_contents('php://input'), true);
if(!isset($input["name"]) || !isset($input["username"]) || !isset($input["bio"]) || !isset($input["location"]) || !isset($input["web"])){
    echo json_encode(["status" => false]);
    exit();
}
$name = $input["name"];
$username = $input["username"];
$bio = $input["bio"];
$location = $input["location"];
$web = $input["web"];

$query = "UPDATE `user` SET `user_name`='$username',`name`='$name', `bio`='$bio',`location`='$location',`web`='$web' WHERE id = '$user_id';";


if(mysqli_query($conn, $query)){
    echo json_encode(["status" => true]);
}else{
    echo json_encode(["status" => false]);
}
?>