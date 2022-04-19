<!DOCTYPE html>
<html lang="pl-PL">

<head>
    <meta charset="UTF-8">
    <meta name="author" content="Maciej Gawłowski">
    <meta name="index" content="none">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="../css/style.css" type="text/css">

    <title>YESmed</title>

</head>

<body>
    <header>
        <h1 class="pageHeader">YESmed Twoja apteka online!</h1>
    </header>

<?php
    echo "<a href='index.php' class='goBack'><img src='../img/arrow.png' alt='arrow' class='goBack'></a>";

    $imgs = "../Img/";
    $zawartosc = scandir($imgs);
    array_shift($zawartosc);
    array_shift($zawartosc);


    foreach ($zawartosc as $img) {
        if (strpos($img, "Towar") !== false) {
            echo "<div class='productDivGaleria'>";
            echo "<h1 class='productName'>$img</h1>";
            echo "<img src='../img/".$img."' alt='".$img."' class='productImgGaleria'>";
            echo "</div>";
        }
    }

?>

<footer>
        <p>Copyright &copy; <a href="https://github.com/gal0wsky">Maciej Gawłowski</a> 2022</p>
    </footer>
</body>

</html>