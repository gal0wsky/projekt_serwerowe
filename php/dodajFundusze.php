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
        echo "<h2>Nie udało się połączyć z bazą danych. Spróbuj ponownie.</h2>";
    else {
        $id = @$_GET["id"];

        echo '<form method="POST">
            <p>Dodaj fundusze (PLN)</p>
            <input type="number" name="kwota">
            <br>
            <button type="submit" name="send">Dodaj fundusze</button>
        </form>';

        if (array_key_exists("send", $_POST)) {
            if (isset($_POST["send"])) {
                $kwota = $_POST["kwota"];

                if ($kwota < 0.00)
                    echo "<h3>Nie można dodać funduszy!</h3>";
                else {
                    $zapytanie = "SELECT * FROM `shoppingcard` WHERE Id=".$_SESSION["userShoppingCard"];
                    $koszyk = mysqli_fetch_array(mysqli_query($baza, $zapytanie));

                    $koszyk["Cash"] += $kwota;

                    $zapytanie = "UPDATE `shoppingcard` SET Cash='".$koszyk["Cash"]."'";

                    $wynik = mysqli_query($baza, $zapytanie);

                    if (!$wynik)
                        echo "<h3>Nie można dodać funduszy!</h3>";
                    else 
                        header("Location: koszyk.php");
                }
            }
        }
    }
?>