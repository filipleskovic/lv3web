<?php
session_start();

if (!isset($_SESSION['user']) || $_SESSION['user']['isAdmin'] != 1) {
    header("Location: lv4.php");
    exit();
}

$host = 'localhost';
$db = 'lv4fl';       
$user = 'root';
$pass = '';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Greška u konekciji: " . $conn->connect_error);
}

$id = $_POST['id'];
$temperature = $_POST['temperature'];
$wind_speed = $_POST['wind_speed'];
$humidity = $_POST['humidity'];
$location = $_POST['location'];
$season = $_POST['season'];
$weather_type = $_POST['weather_type'];

$sql = "INSERT INTO wheaters (id, temperature, wind_speed, humidity, location, season, weather_type)
        VALUES (?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);

if ($stmt === false) {
    die("Greška u pripremi upita: " . $conn->error);
}


$stmt->bind_param("sssssss", $id, $temperature, $wind_speed, $humidity, $location, $season, $weather_type);

if ($stmt->execute()) {
    header("Location: adminDashboard.php");
    exit();
} else {
    echo "Greška prilikom unosa: " . $stmt->error;
}


