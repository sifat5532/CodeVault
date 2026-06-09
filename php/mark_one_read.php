<?php
session_start();
header("Content-Type: application/json");
require 'config.php';

if(!isset($_GET["notif_id"]) || !isset($_SESSION["id"])){
    echo json_encode(["status" => false, "isSet" => false]);
    exit();
}
$notif_id = $_GET["notif_id"];
$user_id = $_SESSION["id"];

$query = "UPDATE `notification` SET `is_read`='1' WHERE who_got = '$user_id' AND id = '$notif_id';";
if(mysqli_query($conn, $query)){
    echo json_encode(["status" => true]);
}else{
    echo json_encode(["status" => false]);
}
?>