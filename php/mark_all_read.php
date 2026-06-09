<?php
session_start();
header("Content-Type: application/json");
if (!isset($_SESSION["id"])) {
    echo json_encode(["status" => false]);
    exit();
}
require "config.php";

$user_id = $_SESSION["id"];

$query = "UPDATE `notification` SET `is_read`='1' WHERE who_got = '$user_id' AND is_read = '0';";

if (mysqli_query($conn, $query)) {
    echo json_encode(["status" => true]);
} else {
    echo json_encode(["status" => false]);
}
?>