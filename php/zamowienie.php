<?php

    session_start();

    include_once("databaseUtilities.php");

    $json = file_get_contents("../resources/login.json");
    $json = json_decode($json, true);

    $profile = getDatabaseConnectionProfile("local");

    $dbName = $profile["databaseName"];
    $dbUser = $profile["mysqlUsername"];
    $dbPassword = $profile["password"];
    $dbHostname = $profile["mysqlHostname"];

    $baza = mysqli_connect($dbHostname, $dbUser, $dbPassword, $dbName);

    echo "<button><a href='koszyk.php'>Wróć</a></button>";

    if (mysqli_connect_errno())
        echo "<h2>Nie można nawiązać połączenia z bazą danych.</h2>";
    else {
        $zapytanie = "SELECT * FROM `shoppingcard` WHERE Id=".$_SESSION["userShoppingCard"];

        $koszykZapytanie = mysqli_query($baza, $zapytanie);

        if (!$koszykZapytanie)
            echo "<h2>Nie można wczytać szczegółów zamówienia.</h2>";
        else {
            $zapytanie = "SELECT * FROM `profiles` WHERE Id=".$_SESSION["userId"];

            $userZapytanie = mysqli_query($baza, $zapytanie);

            if (!$userZapytanie)
                echo "<h2>Nie można wczytać szczegółów zamówienia.</h2>";
            else {
                $koszyk = mysqli_fetch_array($koszykZapytanie);
                $user = mysqli_fetch_array($userZapytanie);

                echo "<h2>Odbiorca: ".$_SESSION["user"]."</h2>";
                echo "<h3>Wartość zamówienia: ".$koszyk["ProductsPrice"]."</h3>";
                echo "<h3>Adres: ".$user["Address"]."</h3>";

                echo '<form method="POST">
                    <h2>Odbiorca: '.$_SESSION["user"].'</h2>
                    <h3>Wartość zamówienia: '.$koszyk["ProductsPrice"].'</h3>
                    <h3>Adres: '.$user["Address"].'</h3>
                    <h3>Dostępne środki: '.$koszyk["Cash"].'</h3>
                    <button name="buy">Zamawiam i płacę</button>
                </form>';

                if (array_key_exists("buy", $_POST)) {
                    if (isset($_POST["buy"])) {
                        if ($koszyk["ProductsPrice"] > $koszyk["Cash"])
                            echo "<h2>Nie posiadasz wystarczająco dużo funduszy.</h2>";
                        else {
                            $reszta = $koszyk["Cash"] - $koszyk["ProductsPrice"];

                            $zapytanie = "DELETE FROM `productslists` WHERE ShoppingCardId=".$_SESSION["userShoppingCard"];

                            $wynik = mysqli_query($baza, $zapytanie);

                            $zapytanie = "UPDATE `shoppingcard` SET Cash=$reszta, ProductsPrice=0.00";

                            $wynik = mysqli_query($baza, $zapytanie);
                            mysqli_close($baza);
                            header("Location: dziekujemy.php");
                        }
                    }
                }
            }
        }
    }

?>