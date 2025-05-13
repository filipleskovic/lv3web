<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['user']) || !isset($_SESSION['user']['user_id'])) {
    echo json_encode(["success" => false, "message" => "User not authenticated"]);
    exit;
}

$user_id = $_SESSION['user']['user_id']; 

$mysqli = new mysqli("localhost", "root", "", "lv4fl");
if ($mysqli->connect_errno) {
    echo json_encode(["success" => false, "message" => "DB connection error"]);
    exit;
}

$query = "SELECT w.id AS weatherId 
          FROM plan p 
          JOIN wheaters w ON p.weatherId = w.id 
          WHERE p.userId = ?";

$stmt = $mysqli->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($weather_id);

$items = [];
while ($stmt->fetch()) {
    $items[] = ['weather_id' => $weather_id];
}

$stmt->close();
$mysqli->close();

echo json_encode(["success" => true, "items" => $items]);
?>
