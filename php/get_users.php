<?php
header("Content-Type: application/json");
require 'config.php';
require 'utility.php';
if(!isset($_GET["searching_for"])){
    echo json_encode(["status" => false]);
    exit();
}
$searching_for = $_GET["searching_for"];

$sql = "SELECT id, name, user_name FROM `user` WHERE user.name LIKE '%$searching_for%' OR user.user_name LIKE '%$searching_for%' ORDER BY user.name ASC;";
$result = mysqli_query($conn, $sql);

$users = [];

while ($row = mysqli_fetch_assoc($result)) {
    $row["avatar"] = get_avatar($row["name"]);
    $users[] = $row;
}

echo json_encode($users);
?>