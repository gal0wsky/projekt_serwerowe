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

    session_start();

    include_once("databaseUtilities.php");

    $json = file_get_contents("../resources/login.json");
    $json = json_decode($json, true);

    $profile = getDatabaseConnectionProfile("remote");

    $dbName = $profile["databaseName"];
    $dbUser = $profile["mysqlUsername"];
    $dbPassword = $profile["password"];
    $dbHostname = $profile["mysqlHostname"];

    $baza = mysqli_connect($dbHostname, $dbUser, $dbPassword, $dbName);

    echo "<a href='index.php' class='goBack'><img src='../img/arrow.png' alt='arrow' class='goBack'></a>";

    if (mysqli_connect_errno())
        echo "<h2>Nie można nawiązać połączenia z bazą danych.</h2>";
    else {
        $zapytanie = "SELECT * FROM `shoppingcard` WHERE Id=".$_SESSION["userShoppingCard"];

        $wynik = mysqli_query($baza, $zapytanie);

        if (!$wynik)
            echo "<h2>Nie można wczytać zawartości koszyka.</h2>";
        else {
            $koszyk = mysqli_fetch_array($wynik);

            $zapytanie = "SELECT * FROM `productslists` WHERE ShoppingCardId=".$_SESSION["userShoppingCard"];

            $wynik = mysqli_query($baza, $zapytanie);

            if (!$wynik)
                echo "<h2>Nie udało się pobrać zawartości koszyka.</h2>";
            else {
                $ileProduktow=0;
                $koszt=0.00;

                echo "<h2 style='color:white;font-size:3em;text-align:center;font-family:ReadexPro;margin:1em;'>Witaj <span class='username'>".$_SESSION["user"]."</span></h2>";
                echo "<p style='color:white;text-align:center;font-family:ReadexPro;font-size:1.5em;margin:1em;'>Twój stan konta: ".$koszyk["Cash"]." zł&nbsp;&nbsp;&nbsp;&nbsp;<button class='doladujKontoButton'><a href='dodajFundusze.php?id=".$koszyk["Id"]."'>Doładuj konto</a></button><br>";

                echo "<h3 style='text-align:center;color:white;font-family:ReadexPro;font-weight:bold;font-size:2em;'>Twoje produkty:</h3><br>";

                echo "<ul>";
                
                while ($wiersz = mysqli_fetch_array($wynik)) {
                    $zapytanie = "SELECT * FROM `products` WHERE Id=".$wiersz["ProductId"];

                    $wynikProdukt = mysqli_query($baza, $zapytanie);
                    $ileProduktow = mysqli_num_rows($wynikProdukt);

                    if (!$wynikProdukt)
                        echo "<h2>Nie udało się pobrać zawartości koszyka.</h2>";
                    else {
                        while ($produkt = mysqli_fetch_array($wynikProdukt)) {
                            $koszt += $produkt["Price"] * $wiersz["Amount"];

                            echo "<div class='productDiv'>";

                            echo "<h3 style='color:white;text-align:center;'>".$produkt["Name"]."<span style='margin-left:2em;font-family:Arial;font-size:0.9em;'>Ilość: ".$wiersz["Amount"]."</span></h3>";
                            echo "<p style='color:white;text-align:center;font-weight:bold;'>".$produkt["Price"]."</p>";
                            echo '<form method="POST" class="Form">
                                <input type="hidden" name="deleteMe" value="'.$produkt["Id"].'">
                                <button name="delete" style="background:none;border:none;"><img src="../img/trash.png" alt="trash" style="width:2em;height:2em;"></button>
                            </form>';

                            if (array_key_exists("delete", $_POST)) {
                                if (isset($_POST["delete"])) {
                                    $productToDelete = $_POST["deleteMe"];
                                    $zapytanie = "DELETE FROM `productslists` WHERE ProductId=$productToDelete";

                                    $wynik = mysqli_query($baza, $zapytanie);
                                    header("Location: koszyk.php");
                                }
                            }

                            echo "</div>";
                        }
                    }
                }
                
                echo "</ul>";

                $zapytanie = "UPDATE `shoppingcard` SET ProductsPrice=$koszt WHERE Id=".$_SESSION["userShoppingCard"];

                $wynik = mysqli_query($baza, $zapytanie);

                if ($ileProduktow > 0) {
                    echo "<div class='button'>";
                    echo "<button><a href='zamowienie.php?id=".$koszyk["Id"]."'>Złóż zamówienie</a></button></div>";
                }
                    
            }
        }
    }
    mysqli_close($baza);

?>

<footer>
        <p>Copyright &copy; <a href="https://github.com/gal0wsky">Maciej Gawłowski</a> 2022</p>
    </footer>
</body>

</html>