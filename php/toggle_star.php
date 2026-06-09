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
if(!isset( $input['repo_id']) || !isset($input['author_id']) || !isset($input['notification_settings'])){
    echo json_encode(["status" => false, "is_logged_in" => true]);
}
$repo_id = $input['repo_id'];
$author_id = $input['author_id'];
$notification_settings = $input['notification_settings'];
$settings = explode("$", $notification_settings);

$query = "SELECT COUNT(*) AS starred FROM stars WHERE user_id = '$user_id' AND repo_id = '$repo_id';";

if(mysqli_fetch_assoc(mysqli_query($conn, $query))["starred"] > 0){
    $q2 = "DELETE FROM `stars` WHERE user_id = '$user_id' AND repo_id = '$repo_id';";
    $is_now_starred = false;
}else{
    $q2 = "INSERT INTO `stars`(`user_id`, `repo_id`) VALUES ('$user_id','$repo_id');";
    $is_now_starred = true;
}

if(mysqli_query($conn, $q2)){
    if($settings[0] == "1" && $author_id != $user_id){
        send_notification($conn, $repo_id, "star", $user_id, $author_id);
    }
    echo json_encode(["status" => true, "is_starred" => $is_now_starred]);
}else{
    echo json_encode(["status" => false, "is_logged_in" => true]);
}

// send notification
function send_notification($conn, $repo_id, $type, $sender_id, $receiver_id){
    $query = "INSERT INTO `notification`(`who_sent`, `who_got`, `repo_id`, `is_read`, `type`) VALUES ('$sender_id','$receiver_id','$repo_id','0','$type')";
    mysqli_query($conn, $query);
}
?>