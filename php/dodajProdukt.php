<?php

    @session_start();

    include_once("databaseUtilities.php");

    $json = file_get_contents("../resources/login.json");
    $json = json_decode($json, true);

    $profile = getDatabaseConnectionProfile("local");

    $dbName = $profile["databaseName"];
    $dbUser = $profile["mysqlUsername"];
    $dbPassword = $profile["password"];
    $dbHostname = $profile["mysqlHostname"];

    $baza = mysqli_connect($dbHostname, $dbUser, $dbPassword, $dbName);

    if (mysqli_connect_errno()) {
        echo "Błąd połączenia z bazą danych!";
    } 
    else {
        echo '<form method="POST">
            <p>Nazwa:</p>
            <input type="text" name="name">
            <p>Cena:</p>
            <input type="number" step="any" name="price">
            <p>Opis:</p>
            <textarea name="desc" cols="50" rows="10"></textarea>
            <p>Grafika:</p>
            <input type="text" name="image">
            <button type="submit" name="send">Dodaj</button>
            <button><a href="bazaProdukty.php">Anuluj</a></button>
        </form>';

        if (isset($_POST["send"])) {
            $name = $_POST["name"];
            $price = $_POST["price"];
            $desc = $_POST["desc"];
            $image = $_POST["image"];

            $zapytanie = "INSERT INTO `products` (Name, Price, Description, Image) VALUES ('$name', '$price', '$desc', '$image')";

            $wynik = mysqli_query($baza, $zapytanie);
            mysqli_close($baza);

            if (!$wynik)
                echo "<h2>Nie można dodać produktu</h2>";
            else 
                header("Location: bazaProdukty.php");
        }
    }

?>