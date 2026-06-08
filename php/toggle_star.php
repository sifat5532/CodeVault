<?php
session_start();
header("Content-Type: application/json");

if(!isset($_SESSION["id"])){
    echo json_encode(["status" => false, "is_logged_in" => false]);
    exit();
}
require "config.php";

$user_id = $_SESSION["id"];

$input = json_decode(file_get_contents('php://input'), true);
if(!isset( $input['repo_id'])){
    echo json_encode(["status" => false, "is_logged_in" => true]);
}
$repo_id = $input['repo_id'];

$query = "SELECT COUNT(*) AS starred FROM stars WHERE user_id = '$user_id' AND repo_id = '$repo_id';";

if(mysqli_fetch_assoc(mysqli_query($conn, $query))["starred"] > 0){
    $q2 = "DELETE FROM `stars` WHERE user_id = '$user_id' AND repo_id = '$repo_id';";
    $is_now_starred = false;
}else{
    $q2 = "INSERT INTO `stars`(`user_id`, `repo_id`) VALUES ('$user_id','$repo_id');";
    $is_now_starred = true;
}

if(mysqli_query($conn, $q2)){
    echo json_encode(["status" => true, "is_starred" => $is_now_starred]);
}else{
    echo json_encode(["status" => false, "is_logged_in" => true]);
}
?>