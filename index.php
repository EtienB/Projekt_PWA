<?php
include 'connect.php';

define('UPLATH', 'img/');

function fetchArticlesByCategory($conn, $category) {
    $query = "SELECT * FROM vijesti WHERE arhiva=0 AND kategorija=? LIMIT 3";
    $stmt = mysqli_prepare($conn, $query);
    
    if (!$stmt) {
        die("Error preparing statement: " . mysqli_error($conn));
    }
    
    mysqli_stmt_bind_param($stmt, "s", $category);
    mysqli_stmt_execute($stmt);
    
    $result = mysqli_stmt_get_result($stmt);
    
    while ($row = mysqli_fetch_array($result)) {
        echo '<article>';
        echo '<div class="article">';
        echo '<div class="img">';
        echo '<img src="'.UPLATH.$row['slika'].'" alt="Article Image">';
        echo '<p>'.$row["naslov"].'</p>';
        echo '<p>'.$row["sazetak"].'</p>';
        echo '</div>';
        echo '<div class="media_body">';
        echo '<h4 class="title">';
        echo '<a href="clanak.php?id='.$row['id'].'">';
        echo htmlspecialchars($row['naslov']);
        echo '</a></h4>';
        echo '</div></div>';
        echo '</article>';
    }
    
    mysqli_stmt_close($stmt);
}
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
            <section class="sport">
                <h2>Sport</h2>
                <?php fetchArticlesByCategory($conn, 'sport'); ?>
            </section>

            <section class="politik">
                <h2>Politik</h2>
                <?php fetchArticlesByCategory($conn, 'politika'); ?>
            </section>
        </main>
    </div>
    <footer id="autor">
        <h3>Etien Bajsić 2024.</h3>
        <h4>ebajsic@tvz.hr</h4>
    </footer>
</body>
</html>

<?php
mysqli_close($conn);
?>
