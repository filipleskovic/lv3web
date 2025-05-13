<?php
session_start();
$user = $_SESSION['user'];
if (!($user['isAdmin'] == 1)) {
    header("Location: lv4.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vrijeme</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.jsdelivr.net/npm/papaparse@5.4.1/papaparse.min.js"></script>
</head>
<body>
    <header>
        <h1>Dobrodosli na stranicu s vremenskom prognozom</h1>
    </header>

    <nav class="nav-menu">
        <ul>
            <li><a href="index.html">Početna</a></li>
            <li><a href="slike.php">Slike</a></li>
            <li><a href="grafikon.html">Grafikoni</a></li>
            <li><a href="auth.html">LV4</a></li>
            <li><a href="logout.php">Logout</a></li>
            <?php if ($user['isAdmin'] == 1): ?>
        <li><a href="adminDashboard.php">Admin</a></li>
    <?php endif; ?>
        </ul>
 
    </nav>
    <h2>Unesi vremenski podatak</h2>
<form action="insertWeather.php" method="POST">
    <label>Id</label>
    <input type="text" name="id" required><br>

    <label>Temperatura (°C):</label>
    <input type="number" name="temperature" step="1" required><br>

    <label>Brzina vJetra (m/s):</label>
    <input type="number" name="wind_speed" step="1" required><br>

    <label>Vlažnost (%):</label>
    <input type="number" name="humidity" required><br>

    <label>Lokacija:</label>
    <select  style ="width: 200px; height: 30px; "name="location" required>
        <option value="inland">Inland</option>
        <option value="mountain">Mountain</option>
        <option value="coastal">Coastal</option>
            </select><br>

    <label>Tip vremena:</label>
    <input type="text" name="weather_type" required><br>
    <label>Sezona:</label>
    <select  style ="width: 200px; height: 30px; "name="season" required>
        <option value="spring">Spring</option>
        <option value="summer">Summer</option>
        <option value="autumn">Jesen</option>
        <option value="winter">Winter</option>
    </select><br>
    <button type="submit" style="margin:10px">Unesi</button>
</form>

<h2>
<form action="deleteWeather.php" method="POST">
        <label for="id">Unesite ID vremenskog podatka:</label>
        <input type="text" name="id" required>
        <button type="submit">Obriši</button>
    </form>
 </h2>
</body>
</html>

