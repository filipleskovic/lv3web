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

if (isset($_POST['id'])) {
    $id = $_POST['id'];

    $sql = "DELETE FROM wheaters WHERE id = ?";

    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die("Greška u pripremi upita: " . $conn->error);
    }

    $stmt->bind_param("s", $id);

    if ($stmt->execute()) {
        echo "Podatak sa ID-om $id je uspješno obrisan.";
    } else {
        echo "Greška prilikom brisanja: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
