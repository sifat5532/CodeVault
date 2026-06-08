<?php
require 'config.php';
require 'utility.php';

$searching_for = $_GET["searching_for"];

$sql = "SELECT id, name, user_name FROM `user` WHERE user.name LIKE '%$searching_for%' OR user.user_name LIKE '%$searching_for%' ORDER BY user.name ASC;";
$result = mysqli_query($conn, $sql);

$users = [];

while ($row = mysqli_fetch_assoc($result)) {
    $row["avatar"] = get_avatar($row["name"]);
    $users[] = $row;
}

header("Content-Type: application/json");
echo json_encode($users);
?>