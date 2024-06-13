<?php
$title=$_POST['title'];
$about=$_POST['about'];
$content=$_POST['content'];
$pphoto=$_POST['pphoto'];
$category=$_POST['category'];
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
                <li><a href="index.html">HOME</a></li>
                <li><a href="sport.html">SPORT</a></li>
                <li><a href="politik.html">POLITIK</a></li>
                <li><a href="admin.html">ADMINISTRACIJA</a> </li>
            </ul> 
        </nav>
    </header>
    <hr class="separator">
    <main>
        <section role="main">
            <div class="row">
                <p class="category">
                    <?php echo $category;?>
                </p>
                <h1 class="title">
                    <?php echo $title;?>
                </h1>  
                <p><?php date("d/m/Y")?></p>   
            </div>
            <section class="slika">
                <?php echo "<img src='$image'";?>
            </section>
            <section class="about">
                <p>
                    <?php echo $about;?>
                </p>
            </section>
            <section class="sadrzaj">
                <p>
                    <?php echo $content;?>
                </p>
            </section>
        </section>
    </main>
    </div>
    <footer id="autor">
        <h3>Etien Bajsić 2024.</h3>
        <h4>ebajsic@tvz.hr</h4>
    </footer>
</body>
</html>