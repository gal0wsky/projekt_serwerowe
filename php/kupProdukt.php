<?php

    session_start();

    echo "<button type='button'><a href='bazaProdukty.php'>Wróć</a></button>";
    echo "<br><br>";

    $id = @$_GET["id"];

    include_once("databaseUtilities.php");

    $json = file_get_contents("../resources/login.json");
    $json = json_decode($json, true);

    $profile = getDatabaseConnectionProfile("local");

    $dbName = $profile["databaseName"];
    $dbUser = $profile["mysqlUsername"];
    $dbPassword = $profile["password"];
    $dbHostname = $profile["mysqlHostname"];

    $baza = mysqli_connect($dbHostname, $dbUser, $dbPassword, $dbName);

    if (mysqli_connect_errno()) 
        echo "Błąd połączenia z bazą danych!";
    else {
        $zapytanie = "SELECT * FROM `products` WHERE Id=$id";

        $wynik = mysqli_query($baza, $zapytanie);

        if (!$wynik)
            echo "<h2>Nie znaleziono produktu!</h2>";
        else {
            $produkt = mysqli_fetch_array($wynik);

            echo "<h1>".$produkt["Name"]."</h1>";
            echo "<br>";
            echo "<h3>Opis:</h3>";
            echo "<p class='productDesc'>".$produkt["Description"]."</p>";
            echo "<br>";
            echo '<form method="POST">
                <h3>Ilość:</h3>
                <input type="number" name="amount">
                <br><br>
                <button type="submit" name="order">Dodaj do koszyka</button>
            </form>';
            echo "<br><br>";
            echo "<img class='productImg' src='../img/".$produkt["Image"]."' alt='".$produkt["Image"]."'></img>";

            if (array_key_exists("order", $_POST)) {
                if (isset($_POST["order"])) {
                    $ilosc = $_POST["amount"];
                    
                    $zapytanie = "INSERT INTO `productslists` (ShoppingCardId, ProductId, Amount) VALUES((SELECT Id FROM `shoppingcard` WHERE UserId=".$_SESSION["userId"]."), (SELECT Id FROM `products` WHERE Id=$id), $ilosc)";
                    $wynik = mysqli_query($baza, $zapytanie);
                    mysqli_close($baza);

                    if (!$wynik)
                        echo "<h2>Nie można dodać produktu do koszyka.</h2>";
                    else 
                        header("Location: bazaProdukty.php");
                }
            }
        }
    }
    mysqli_close($baza);

?>