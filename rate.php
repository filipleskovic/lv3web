<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: auth.html");
    exit;
}

$user = $_SESSION['user'];
$userId = $user['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['imageId'], $_POST['rate'])) {
    $imageId = (int)$_POST['imageId'];
    $rate = (int)$_POST['rate'];

    if ($rate < 1 || $rate > 5) {
        die("Neispravna ocjena.");
    }

    $conn = new mysqli('localhost', 'root', '', 'lv4fl');
    if ($conn->connect_error) {
        die("Greška pri povezivanju: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("SELECT id FROM rate WHERE userId = ? AND imageId = ?");
    $stmt->bind_param("ii", $userId, $imageId);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->close();
        $update = $conn->prepare("UPDATE rate SET rate = ? WHERE userId = ? AND imageId = ?");
        $update->bind_param("iii", $rate, $userId, $imageId);
        $update->execute();
        $update->close();
    } else {
        $stmt->close();
        $insert = $conn->prepare("INSERT INTO rate (userId, imageId, rate) VALUES (?, ?, ?)");
        $insert->bind_param("iii", $userId, $imageId, $rate);
        $insert->execute();
        $insert->close();
    }

    $conn->close();

    header("Location: slike.php");
    exit;
} else {
    echo "Neispravni podaci.";
}
?>
