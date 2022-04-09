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
    include("opinie.php");
    include("galeria.php");
    include("zgloszenie.php");
    include("regex.php");
    include("baza.php");
    include("bazaProdukty.php");
    include("edycja.php");
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

        <h2>Menu:</h2>
        <ul>
            <?php

                echo "<li><a href='index.php'>Strona główna</a></li>";
                echo "<li><a href='index.php?id=produkty'>Produkty</a></li>";
                echo "<li><a href='index.php?id=kontakt'>Kontakt</a></li>";
                echo "<li><a href='index.php?id=galeria'>Galeria</a></li>";

                if (isset($_SESSION["role"])) {

                    if ($_SESSION["role"] == 3) {
                        echo "<li><a href='index.php?id=opinie'>Opinie</a></li>";
                    }
    
                    if ($_SESSION["role"] == 2) {
                        echo "<li><a href='index.php?id=editProduct'>Edytuj produkt</a></li>";
                        echo "<li><a href='index.php?id=opinie'>Opinie</a></li>";
                    }

                    if ($_SESSION["role"] == 1) {
                        echo "<li><a href='index.php?id=editOpinions'>Zarządzaj opiniami</a></li>";
                        echo "<li><a href='index.php?id=editProduct'>Edytuj produkt</a></li>";
                        echo "<li><a href='index.php?id=opinie'>Opinie</a></li>";
                    }
                    
                    echo "<li><a href='index.php?id=wyloguj'>Wyloguj</a></li>";
                }
            ?>
            <!-- <li><a href="index.php?id=opinie">Opinie</a></li> -->
            <!-- <li><a href="index.php?id=zgloszenie">Zgłoszenie</a></li>
            <li><a href="index.php?id=regex">Regex</a></li>
            <li><a href="index.php?id=baza">Baza</a></li> -->
            <!-- <li><a href="index.php?id=editProduct">Edytuj produkt</a></li>
            <li><a href="index.php?id=wyloguj">Wyloguj</a></li> -->
        </ul>
    </nav>

    <main>

        <?php

        $href = @$_GET["id"];

        if ($href == "kontakt")
            kontakt();
        else if ($href == "opinie")
            opinie();
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
            getProducts();
        else if ($href == "editProduct")
            getAllProducts();
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