<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);
header('Content-Type: application/json');

$mysqli = new mysqli("localhost", "root", "", "lv4fl");
if ($mysqli->connect_errno) {
    echo json_encode(["success" => false, "message" => "DB connection error: " . $mysqli->connect_error]);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);
$weatherIds = isset($data['weatherIds']) ? $data['weatherIds'] : [];

if (!isset($_SESSION['user']) || !isset($_SESSION['user']['user_id'])) {
    echo json_encode(["success" => false, "message" => "User not authenticated"]);
    exit;
}

$user_id = $_SESSION['user']['user_id']; 

foreach ($weatherIds as $weather_id) {
    $stmt = $mysqli->prepare("INSERT INTO plan (userId, weatherId) VALUES (?, ?)");
    if (!$stmt) {
        echo json_encode(["success" => false, "message" => "Prepare failed: " . $mysqli->error]);
        exit;
    }

    $stmt->bind_param("is", $user_id, $weather_id);  
    if (!$stmt->execute()) {
        echo json_encode(["success" => false, "message" => "Execute failed: " . $stmt->error]);
        $stmt->close();
        exit;
    }

    $stmt->close();
}

echo json_encode(["success" => true]);
?>
