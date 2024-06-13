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
include 'connect.php'; 
define('UPLATH', 'img/');

$query = "SELECT * FROM vijesti";
$result = mysqli_query($conn, $query);

while ($row = mysqli_fetch_array($result)) {
    ?>
    <form enctype="multipart/form-data" action="" method="POST">
        <div class="form-item">
            <label for="title">Naslov vijesti</label>
            <div class="form-field">
                <input type="text" name="title" class="form-field-textual"
                       value="<?= htmlspecialchars($row['naslov']) ?>">
            </div>
        </div>
        <div class="form-item">
            <label for="about">Kratki sadržaj vijesti (do 50 znakova)</label>
            <div class="form-field">
                <textarea name="about" cols="30" rows="10"
                          class="form-field-textual"><?= htmlspecialchars($row['sazetak']) ?></textarea>
            </div>
        </div>
        <div class="form-item">
            <label for="content">Sadržaj vijesti</label>
            <div class="form-field">
                <textarea name="content" cols="30" rows="10"
                          class="form-field-textual"><?= htmlspecialchars($row['tekst']) ?></textarea>
            </div>
        </div>
        <div class="form-item">
            <label for="pphoto">Slika:</label>
            <div class="form-field">
                <input type="file" class="input-text" id="pphoto" name="pphoto"/>
                <br><img src="<?= UPLATH . htmlspecialchars($row['slika']) ?>" width="100px">
            </div>
        </div>
        <div class="form-item">
            <label for="category">Kategorija vijesti</label>
            <div class="form-field">
                <select name="category" class="form-field-textual">
                    <option value="sport" <?= ($row['kategorija'] == 'sport') ? 'selected' : '' ?>>Sport</option>
                    <option value="politika" <?= ($row['kategorija'] == 'politika') ? 'selected' : '' ?>>Politika</option>
                </select>
            </div>
        </div>
        <div class="form-item">
            <label>Spremiti u arhivu?</label>
            <div class="form-field">
                <input type="checkbox" name="archive" id="archive" <?= ($row['arhiva'] == 1) ? 'checked' : '' ?>>
            </div>
        </div>
        <input type="hidden" name="id" value="<?= $row['id'] ?>">
        <div class="form-item">
            <button type="reset" value="Poništi">Poništi</button>
            <button type="submit" name="update" value="Prihvati">Izmjeni</button>
            <button type="submit" name="delete" value="Izbriši">Izbriši</button>
        </div>
    </form>
    </main>
    </div>
    <footer id="autor">
        <h3>Etien Bajsić 2024.</h3>
        <h4>ebajsic@tvz.hr</h4>
    </footer>

    <script>
        document.getElementById("slanje").onclick = function(event) {
            var slanjeForme = true;
            
            var poljeTitle = document.getElementById("title");
            var title = document.getElementById("title").value;
            if (title.length < 5 || title.length > 30) {
                slanjeForme = false;
                poljeTitle.style.border = "1px dashed red";
                document.getElementById("porukaTitle").innerHTML = "Naslov vijesti mora imati između 5 i 30 znakova!<br>";
            } else {
                poljeTitle.style.border = "1px solid green";
                document.getElementById("porukaTitle").innerHTML = "";
            }
            
            var poljeAbout = document.getElementById("about");
            var about = document.getElementById("about").value;
            if (about.length < 10 || about.length > 100) {
                slanjeForme = false;
                poljeAbout.style.border = "1px dashed red";
                document.getElementById("porukaAbout").innerHTML = "Kratki sadržaj mora imati između 10 i 100 znakova!<br>";
            } else {
                poljeAbout.style.border = "1px solid green";
                document.getElementById("porukaAbout").innerHTML = "";
            }
            
            var poljeContent = document.getElementById("content");
            var content = document.getElementById("content").value;
            if (content.length == 0) {
                slanjeForme = false;
                poljeContent.style.border = "1px dashed red";
                document.getElementById("porukaContent").innerHTML = "Sadržaj mora biti unesen!<br>";
            } else {
                poljeContent.style.border = "1px solid green";
                document.getElementById("porukaContent").innerHTML = "";
            }
            
            var poljeSlika = document.getElementById("ppphoto");
            var ppphoto = document.getElementById("ppphoto").value;
            if (ppphoto.length == 0) {
                slanjeForme = false;
                poljeSlika.style.border = "1px dashed red";
                document.getElementById("porukaSlika").innerHTML = "Slika mora biti unesena!<br>";
            } else {
                poljeSlika.style.border = "1px solid green";
                document.getElementById("porukaSlika").innerHTML = "";
            }
            
            var poljeCategory = document.getElementById("category");
            if (document.getElementById("category").selectedIndex == 0) {
                slanjeForme = false;
                poljeCategory.style.border = "1px dashed red";
                document.getElementById("porukaKategorija").innerHTML = "Kategorija mora biti odabrana!<br>";
            } else {
                poljeCategory.style.border = "1px solid green";
                document.getElementById("porukaKategorija").innerHTML = "";
            }
            
            if (!slanjeForme) {
                event.preventDefault();
            }
        };
    </script>
</body>
</html>
    <?php
}

if (isset($_POST['delete'])) {
    $id = $_POST['id'];
    $query = "DELETE FROM vijesti WHERE id=?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $about = $_POST['about'];
    $content = $_POST['content'];
    $category = $_POST['category'];
    $archive = isset($_POST['archive']) ? 1 : 0;

    $picture = $_FILES['pphoto']['name'];
    if (!empty($picture)) {
        $target_dir = 'img/' . $picture;
        move_uploaded_file($_FILES["pphoto"]["tmp_name"], $target_dir);
    } else {
        $picture = $row['slika'];
    }

    $query = "UPDATE vijesti SET naslov=?, sazetak=?, tekst=?, slika=?, kategorija=?, arhiva=? WHERE id=?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "ssssssi", $title, $about, $content, $picture, $category, $archive, $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

mysqli_close($conn);
?>
