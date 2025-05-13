<?php
$mysqli = new mysqli("localhost", "root", "", "lv4fl");

if ($mysqli->connect_errno) {
    die("Greška u konekciji: " . $mysqli->connect_error);
}

$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

if (!$email || !$password) {
    die("Unesite email i lozinku.");
}

$stmt = $mysqli->prepare("SELECT id, name, hash, isAdmin FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->bind_result($id, $fetched_name, $hash_from_db, $is_admin);
$stmt->fetch();
$stmt->close();

if ($hash_from_db && password_verify($password, $hash_from_db)) {
    session_start();
    $_SESSION['user'] = [
        'name' => $fetched_name,
        'email' => $email,
        'user_id' => $id,
        'isAdmin' => $is_admin
    ];
    header("Location: lv4.php");
    exit;
} else {
    die("Neispravni podaci.");
}
