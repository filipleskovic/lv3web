
<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: auth.html");
    exit;
}
$user = $_SESSION['user'];
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

    <div id="filteri">
        <select id="filter-genre">
            <option value="">Odaberi Sezonu</option>
            <option value="Spring">Spring</option>
            <option value="Summer">Summer</option>
            <option value="Autumn">Autumn</option>
            <option value="Winter">Winter</option>
        </select>
        <input type="number" id="filter-temperature" placeholder="Temperatura od" style="max-width: 400px;">
        <div class="inputButtons" >
            <input type="radio" id="inland" name="location" value="inland">
            <label for="inland">Inland</label>
            <input type="radio" id="mountain" name="location" value="mountain">
            <label for="mountain">Mountain</label>
            <input type="radio" id="coastal" name="location" value="coastal">
            <label for="coastal">Coastal</label>
        </div>
        <button id="primijeni-filtere" style="margin-left: 30px;">Filtriraj</button>
    </div>
    <div class="user-info" style="padding: 10px; background-color: #f0f0f0;">
    <h2>Dobrodošao, <?php echo htmlspecialchars($user['name']); ?>!</h2>
    <p>Email: <?php echo htmlspecialchars($user['email']); ?></p>
    <p>Korisnički ID: <?php echo htmlspecialchars($user['user_id']); ?></p>
    <p>ADMIN: <?php echo htmlspecialchars($user['isAdmin']); ?></p>
</div>
    <div class="tableAndAside">
        <div class="tableAndButton">
            <table id="vrijeme-tablica2">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Temperature (°C)</th>
                        <th>Humidity (%)</th>
                        <th>Wind Speed (km/h)</th>
                        <th>Season</th>
                        <th>Location</th>
                        <th>Weather Type</th>
                    </tr>
                </thead>
                <tbody id="weather-table-body">
                </tbody>
            </table>
            <div>
                <button id="add-to-cart" onclick="addToPlan()">Add to Cart</button>
            </div>
        </div>
        <aside>
            <div>
                <section id="kosarica-content">
                    <h2>Moja kosarica</h2>
                    <ul id="lista-kosarice">
                    </ul>
                    <button id="potvrdi-kosaricu" onclick="deletePlan()">Potvrdi odabir</button>
                </section>
            </div>
        </aside>
        </div>
    </div>

    <footer>
        <p>© 2025. Web Programiranje. Sva prava pridržana.</p>
    </footer>

    <script src="fetchdata.js"></script>
    <script>
    document.addEventListener("DOMContentLoaded", function () {
    fetchCartItems();
});
</script>
    <script src="deletePlan.js"></script>
    <script src="open_weather_detail.js"></script>
    <script src="filters.js"></script>
    <script src = "script.js"></script>
    <script src="addToPlan.js"></script>
</body>
</html>
