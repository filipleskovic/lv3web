<?php
$host = 'localhost';
$user = 'root';
$pass = ''; 
$dbname = 'lv4fl'; 

$conn = mysqli_connect($host, $user, $pass, $dbname);

if (!$conn) {
    die("Greška pri povezivanju na bazu: " . mysqli_connect_error());
}

$sql = "SELECT * FROM wheaters"; 
$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Greška u SQL upitu: " . mysqli_error($conn));
}

$data = [];
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}

mysqli_close($conn);

echo json_encode($data);
?>
