<?php
// 1. Konekcija na MySQL pomoću mysqli_connect
$host = 'localhost';
$user = 'root';
$pass = ''; // dodaj lozinku ako je postavljena
$dbname = 'lv4fl'; // zamijeni s imenom svoje baze

$conn = mysqli_connect($host, $user, $pass, $dbname);

// Provjera konekcije
if (!$conn) {
    die("Greška pri povezivanju na bazu: " . mysqli_connect_error());
}

// 2. Otvori CSV datoteku
$csvFile = fopen("weather.csv", "r");
if (!$csvFile) {
    die("Nije moguće otvoriti CSV datoteku.");
}

// 3. Preskoči zaglavlje
fgetcsv($csvFile);

// 4. Čitanje svakog reda i unos u bazu
while (($row = fgetcsv($csvFile)) !== FALSE) {
    // Mapa kolona
    $id = mysqli_real_escape_string($conn, $row[0]);
    $temperature = (float)$row[1];
    $humidity = (int)$row[2];
    $wind_speed = (float)$row[3];
    $location = mysqli_real_escape_string($conn, $row[10]);
    $season = mysqli_real_escape_string($conn, $row[8]);
    $weather_type = mysqli_real_escape_string($conn, $row[11]);

    // SQL upit
    $sql = "INSERT INTO wheaters (id, temperature, humidity, wind_speed, location, season, weather_type)
            VALUES ('$id', $temperature, $humidity, $wind_speed, '$location', '$season', '$weather_type')";

    if (mysqli_query($conn, $sql)) {
        echo "Red s ID $id je unesen.<br>";
    } else {
        echo "Greška pri unosu reda s ID $id: " . mysqli_error($conn) . "<br>";
    }
}

// Zatvori fajl i konekciju
fclose($csvFile);
mysqli_close($conn);

echo "<br>Gotovo!";
?>
