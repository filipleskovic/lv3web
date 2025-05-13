<?php
header('Content-Type: application/json');
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);

$mysqli = new mysqli("localhost", "root", "", "lv4fl");
if ($mysqli->connect_errno) {
    echo json_encode(["success" => false, "message" => "DB error: " . $mysqli->connect_error]);
    exit;
}

if (!isset($_SESSION['user']) || !isset($_SESSION['user']['user_id'])) {
    echo json_encode(["success" => false, "message" => "Not authenticated"]);
    exit;
}

$user_id = $_SESSION['user']['user_id'];

$data = json_decode(file_get_contents("php://input"), true);
$weather_id = $data['weather_id'] ?? null;

if (!$weather_id) {
    echo json_encode(["success" => false, "message" => "No weather_id provided"]);
    exit;
}

$stmt = $mysqli->prepare("DELETE FROM plan WHERE userId = ? AND weatherId = ?");
$stmt->bind_param("is", $user_id, $weather_id);
if ($stmt->execute()) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false, "message" => "Delete failed: " . $stmt->error]);
}
$stmt->close();
