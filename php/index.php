<?php

    session_start();

?>

<!DOCTYPE html>
<html lang="pl-PL">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>YESmed</title>

    <?php
    include("towary.php");
    include("kontakt.php");
    include("galeria.php");
    include("zgloszenie.php");
    include("regex.php");
    include("baza.php");
    ?>
</head>

<body>
    <header>
        <h1 class="centerVertically">YESmed Twoja apteka online!</h1>
    </header>

    <nav>
        <ul id="logAndSignOptions">
            <?php
            
                if (!isset($_SESSION["role"])) {
                    echo "<li><a href='index.php?id=rejestracja'>Zarejestruj</a></li>";
                }

                if (!isset($_SESSION["role"]) && isset($_SESSION))
                    echo "<li><a href='index.php?id=logowanie'>Zaloguj</a></li>";
            
            ?>
        </ul>

        <?php
        
            if (isset($_SESSION["role"])) {
                echo "Jesteś zalogowany jako: ".$_SESSION["user"];
            }
        
        ?>

        <h2>Menu:</h2>
        <ul>
            <?php

                echo "<li><a href='index.php'>Strona główna</a></li>";
                echo "<li><a href='index.php?id=produkty'>Produkty</a></li>";
                echo "<li><a href='index.php?id=kontakt'>Kontakt</a></li>";
                echo "<li><a href='index.php?id=galeria'>Galeria</a></li>";

                if (isset($_SESSION["role"])) {
                    echo "<li><a href='index.php?id=opinie'>Opinie</a></li>";
                    echo "<li><a href='index.php?id=koszyk'>Koszyk</a></li>";
                    echo "<li><a href='index.php?id=wyloguj'>Wyloguj</a></li>";
                }
            ?>
        </ul>
    </nav>

    <main>

        <?php

        $href = @$_GET["id"];

        if ($href == "kontakt")
            kontakt();
        else if ($href == "opinie")
            header("Location: opinie.php");
        else if ($href == "galeria")
            galeria();
        else if ($href == "zgloszenie")
            zgloszenie();
        else if ($href == "regex")
            regexForm();
        else if ($href == "baza")
            opinieForm();
        else if ($href == "rejestracja")
            header("Location: rejestracja.php");
        else if ($href == "logowanie")
            header("Location: logowanie.php");
        else if ($href == "produkty")
            header("Location: bazaProdukty.php");
        else if ($href == "koszyk")
            header("Location: koszyk.php");
        else if ($href == "wyloguj")
            header("Location: wyloguj.php");
        else
            towary();
        ?>
    </main>

    <footer>
        <p class="centerVertically">Copyright &copy; <a href="https://github.com/gal0wsky">Maciej Gawłowski</a> 2021</p>
    </footer>
</body>

</html>