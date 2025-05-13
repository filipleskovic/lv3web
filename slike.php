<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: auth.html");
    exit;
}
$user = $_SESSION['user'];
?>
<!DOCTYPE html>
	<html lang="hr">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" href="style_slike.css">
		<title>Vrijeme</title> 
	</head>
	<body>
		<header>
		<h1>Dobrodosli na stranciu s vremenskom prognozom</h1>
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

<h1>Galerija slika</h1>
<section class="galerija"> 


<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$db   = 'lv4fl';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Greška prilikom povezivanja: " . $conn->connect_error);
}

$sql = "SELECT id, url FROM images LIMIT 4";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0):
    $index = 1;
    while($row = $result->fetch_assoc()):
		$imageId = $row['id'];
        $sql_rating = "SELECT AVG(rate) AS average_rating FROM rate WHERE imageId = $imageId";
        $rating_result = $conn->query($sql_rating);
        $average_rating = 0;
        if ($rating_result && $rating_result->num_rows > 0) {
            $rating_row = $rating_result->fetch_assoc();
            $average_rating = round($rating_row['average_rating'], 2);
        }

?>
    <figure class="galerija_slika">
        <a href="#lightbox<?= $index ?>" class="image-popup-vertical-fit">
            <img src="<?= htmlspecialchars($row['url']) ?>" style="width:300px;height:200px;"alt="Slika <?= $index ?> ">
        </a>
		<figcaption>Slika <?= $index ?> | Prosječna ocjena: <?= $average_rating ? $average_rating : "Nema ocjena" ?></figcaption>
				<form method="post" action="rate.php">
    <input type="hidden" name="imageId" value="<?= $row['id'] ?>">

    <select  style ="width: 200px; height: 30px; "name="rate" required>
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
		<option value="4">4</option>
		<option value="5">5</option>

            </select><br>
    <button type="submit">Ocijeni</button>
    </form>
    </figure>
<?php
        $index++;
    endwhile;
else:
    echo "<p>Nema dostupnih slika.</p>";
endif;

$conn->close();
?>
</section>
</body>
</html>