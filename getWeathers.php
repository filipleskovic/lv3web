<?php
// Konekcija na bazu
$host = 'localhost';
$user = 'root';
$pass = ''; // Ako koristiš lozinku za MySQL, ovdje ju stavi
$dbname = 'lv4fl'; // Ime tvoje baze

$conn = mysqli_connect($host, $user, $pass, $dbname);

if (!$conn) {
    die("Greška pri povezivanju na bazu: " . mysqli_connect_error());
}

// Dohvati podatke iz baze
$sql = "SELECT * FROM wheaters"; // Prilagodi ovo prema svojoj tablici
$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Greška u SQL upitu: " . mysqli_error($conn));
}

$data = [];
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}

// Zatvori konekciju
mysqli_close($conn);

// Pretvori podatke u JSON format za JavaScript
echo json_encode($data);
?>
