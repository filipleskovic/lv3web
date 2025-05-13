<?php
$mysqli = new mysqli("localhost", "root", "", "lv4fl");

if ($mysqli->connect_errno) {
    die("Greška u konekciji: " . $mysqli->connect_error);
}

$name = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

if (!$name || !$email || !$password) {
    die("Sva polja su obavezna.");
}

$hashed_password =  

$stmt = $mysqli->prepare("SELECT id FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    die("Email je već registriran.");
}

$stmt->close();

$stmt = $mysqli->prepare("INSERT INTO users (name, email, password, hash) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $name, $email, $password, $hashed_password);
$stmt->execute();

$stmt->close();
$mysqli->close();

header("Location: auth.html?success=1");
exit;
