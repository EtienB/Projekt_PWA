<?php
include 'connect.php'; 
define('UPLATH', 'img/');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $picture = $_FILES['pphoto']['name'];
    $title = $_POST['title'];
    $about = $_POST['about'];
    $content = $_POST['content'];
    $category = $_POST['category'];
    $archive = isset($_POST['archive']) ? 1 : 0;
    $date = date('Y-m-d');  
    
    $target_dir = 'img/' . basename($picture);

    if (move_uploaded_file($_FILES['pphoto']['tmp_name'], $target_dir)) {
        $stmt = $conn->prepare("INSERT INTO Vijesti (datum, naslov, sazetak, tekst, slika, kategorija, arhiva) VALUES (?, ?, ?, ?, ?, ?, ?)");
        if ($stmt === false) {
            die("Error preparing the statement: " . $conn->error);
        }

        $stmt->bind_param('ssssssi', $date, $title, $about, $content, $picture, $category, $archive);

        if ($stmt->execute()) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}

$conn->close();
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
        <form enctype="multipart/form-data" action="unos.php" method="POST" id="unosForma">
            <div class="form-item">
                <span id="porukaTitle" class="bojaPoruke"></span>
                <label for="title">Naslov vijesti</label>
                <div class="form-field">
                    <input type="text" id="title" name="title" class="form-field-textual">
                </div>
            </div>
            <div class="form-item">
                <span id="porukaAbout" class="bojaPoruke"></span>
                <label for="about">Kratki sadržaj vijesti (do 50 znakova)</label>
                <div class="form-field">
                    <textarea id="about" name="about" cols="30" rows="10" class="form-field-textual"></textarea>
                </div>
            </div>
            <div class="form-item">
                <span id="porukaContent" class="bojaPoruke"></span>
                <label for="content">Sadržaj vijesti</label>
                <div class="form-field">
                    <textarea id="content" name="content" cols="30" rows="10" class="form-field-textual"></textarea>
                </div>
            </div>
            <div class="form-item">
                <span id="porukaSlika" class="bojaPoruke"></span>
                <label for="pphoto">Slika:</label>
                <div class="form-field">
                    <input type="file" accept="image/jpg, image/gif" id="ppphoto" name="pphoto" class="input-text">
                </div>
            </div>
            <div class="form-item">
                <span id="porukaKategorija" class="bojaPoruke"></span>
                <label for="category">Kategorija vijesti</label>
                <div class="form-field">
                    <select id="category" name="category" class="form-field-textual">
                        <option value="" disabled selected>Odabir kategorije</option>
                        <option value="sport">Sport</option>
                        <option value="politika">Politika</option>
                    </select>
                </div>
            </div>
            <div class="form-item">
                <label for="arhiva">Spremiti u arhivu?
                <div class="form-field">
                    <input type="checkbox" name="archive" id="archive">
                </div>
                </label>
            </div>
            <div class="form-item">
                <button type="reset" value="Poništi">Poništi</button>
                <button type="submit" value="Prihvati" id="slanje">Prihvati</button>
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
