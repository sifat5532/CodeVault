<?php

require "config.php";
// return true if username exists, otherwise false
if(!isset($_GET["username"])){
    header("Location: ../index.php");
    exit();
}
$user_name = $_GET["username"];

$sql = "SELECT * FROM user WHERE user_name = '$user_name'";

if ($result = mysqli_query($conn, $sql)) {
    if (mysqli_num_rows($result) > 0) {
        $response = ["status" => true];
    }else{
        $response = ["status" => false];
    }
}else{
    $response = ["status" => false];
}


header("Content-Type: application/json");
echo json_encode($response);
?>