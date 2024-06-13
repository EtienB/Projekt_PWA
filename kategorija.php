<?php
include 'connect.php';
define('UPLATH', 'img/');
?>

<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>RP ONLINE</title>
</head>
<body>
    <div class="container">
    <header>
        <div class="logo">
            <img src="logo.png" alt="RP ONLINE logo" id="logo">
        </div>
        <nav class="navigacija">
            <ul>
                <li><a href="index.php">HOME</a></li>
                <li><a href="kategorija.php?id=sport">SPORT</a></li>
                <li><a href="kategorija.php?id=politika">POLITIKA</a></li>
                <li><a href="administracija.php">ADMINISTRACIJA</a></li>
                <li><a href="unos.php">UNOS</a></li>
            </ul> 
        </nav>
    </header>
    <hr class="separator">
    <main>
    <?php
$kategorija=$_GET['id'];
$stmt=$conn->prepare("SELECT * FROM vijesti WHERE arhiva=0 AND kategorija=?");

if ($stmt === false) {
    die("Error preparing the statement: " . $conn->error);
}
$stmt->bind_param("s", $kategorija);

$stmt->execute();

$result = $stmt->get_result();

while($row = $result->fetch_assoc())
{
    echo '<article>';
    echo '<div class="article">';
    echo '<div class="img">';
    echo '<img src="'.UPLATH.$row['slika'].'"';
    echo '</div>';
    echo '<div class="media_body">';
    echo '<h4 class="title">';
    echo '<a href="clanak.php?id='.$row['id'].'">';
    echo $row['naslov'];
    echo '</a></h4>';
    echo '</div></div>';
    echo '</article>';
}
$stmt->close();
?>
    </main>
    </div>
    <footer id="autor">
        <h3>Etien Bajsić 2024.</h3>
        <h4>ebajsic@tvz.hr</h4>
    </footer>
</body>
</html>

