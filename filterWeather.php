<?php
header('Content-Type: application/json');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "lv4fl";

$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    http_response_code(500);
    echo json_encode(["error" => "Neuspješna konekcija s bazom."]);
    exit;
}

$season = $_GET['season'] ?? '';
$min_temp = isset($_GET['min_temperature']) ? (int)$_GET['min_temperature'] : null;
$location = $_GET['location'] ?? '';

$sql = "SELECT id, temperature, humidity, wind_speed, season, location, weather_type FROM vrijeme WHERE 1=1";
$params = [];

if (!empty($season)) {
    $sql .= " AND season = ?";
    $params[] = $season;
}
if (!is_null($min_temp)) {
    $sql .= " AND temperature >= ?";
    $params[] = $min_temp;
}
if (!empty($location)) {
    $sql .= " AND location = ?";
    $params[] = $location;
}

$stmt = mysqli_prepare($conn, $sql);
if (!empty($params)) {
    $types = '';
    foreach ($params as $p) {
        $types .= is_int($p) ? 'i' : 's';
    }
    mysqli_stmt_bind_param($stmt, $types, ...$params);
}

mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$data = [];
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}

mysqli_stmt_close($stmt);
mysqli_close($conn);

echo json_encode($data);
