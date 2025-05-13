<?php
$host = 'localhost';
$user = 'root';
$pass = ''; 
$dbname = 'lv4fl'; 

$conn = mysqli_connect($host, $user, $pass, $dbname);

if (!$conn) {
    die("Greška pri povezivanju na bazu: " . mysqli_connect_error());
}

$csvFile = fopen("weather.csv", "r");
if (!$csvFile) {
    die("Nije moguće otvoriti CSV datoteku.");
}

fgetcsv($csvFile);

while (($row = fgetcsv($csvFile)) !== FALSE) {
    $id = mysqli_real_escape_string($conn, $row[0]);
    $temperature = (float)$row[1];
    $humidity = (int)$row[2];
    $wind_speed = (float)$row[3];
    $location = mysqli_real_escape_string($conn, $row[10]);
    $season = mysqli_real_escape_string($conn, $row[8]);
    $weather_type = mysqli_real_escape_string($conn, $row[11]);

    $sql = "INSERT INTO wheaters (id, temperature, humidity, wind_speed, location, season, weather_type)
            VALUES ('$id', $temperature, $humidity, $wind_speed, '$location', '$season', '$weather_type')";

    if (mysqli_query($conn, $sql)) {
        echo "Red s ID $id je unesen.<br>";
    } else {
        echo "Greška pri unosu reda s ID $id: " . mysqli_error($conn) . "<br>";
    }
}

fclose($csvFile);
mysqli_close($conn);

echo "<br>Gotovo!";
?>
