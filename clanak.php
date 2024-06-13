<?php
include 'connect.php';
define('UPLATH', 'img/');


if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $conn->prepare("SELECT * FROM vijesti WHERE id=?");
    if ($stmt === false) {
        die("Error preparing the statement: " . $conn->error);
    }
    $stmt->bind_param("i", $id);

    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        die("No article found with the provided id.");
    }

    $stmt->close();
} else {
    die("Invalid or missing article id.");
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
        <section role="main">
            <div class="row">
            <h1 class="title"><?php
            echo $row['naslov'];?></h1>
            <section class="slika">
                <?php
                echo '<img src="'.UPLATH.$row['slika'].'">';?>
            </section>
            <section class="about">
            <p>
            <?php
            echo "<i>".$row['sazetak']."</i>";
            ?>
            </p>
            </section>
            <section class="sadrzaj">
            <p>
            <?php
            echo $row['tekst'];
            ?>
            </p>
            </section>
            </section>
            </div>
        </section>
    </main>
    </div>
    <footer id="autor">
        <h3>Etien Bajsić 2024.</h3>
        <h4>ebajsic@tvz.hr</h4>
    </footer>
</body>
</html>