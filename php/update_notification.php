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

$str = $input["string"];


$query = "UPDATE `user` SET notification_settings = '$str' WHERE id = '$user_id';";


if(mysqli_query($conn, $query)){
    echo json_encode(["status" => true]);
}else{
    echo json_encode(["status" => false]);
}
?>