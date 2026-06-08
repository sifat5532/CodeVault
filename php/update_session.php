<?php
session_start();

$data = json_decode(file_get_contents("php://input"), true);

if (isset($data["username"])) {
    $_SESSION["username"] = $data["username"];

    echo json_encode([
        "status" => true,
        "message" => "Session updated"
    ]);
} else {
    echo json_encode([
        "status" => false,
        "message" => "No username provided"
    ]);
}