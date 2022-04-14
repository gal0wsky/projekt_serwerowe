<?php

    include_once("databaseUtilities.php");

    $json = file_get_contents("../resources/login.json");
    $json = json_decode($json, true);

    $profile = getDatabaseConnectionProfile("local");

    $dbName = $profile["databaseName"];
    $dbUser = $profile["mysqlUsername"];
    $dbPassword = $profile["password"];
    $dbHostname = $profile["mysqlHostname"];

    $baza = mysqli_connect($dbHostname, $dbUser, $dbPassword, $dbName);

    $id = @$_GET["id"];

    if (mysqli_connect_errno()) {
        echo "Coś poszło nie tak.";
    }
    else {
        $zapytanie = "SELECT * FROM Products WHERE Id=$id";
        $wynik = mysqli_query($baza, $zapytanie);

        if (!$wynik)
            echo "Nie można pobrać produktu z bazy danych!";
        else {
            displayEditProductForm($wynik);

            if (isset($_POST["cancel"])) {
                mysqli_close($baza);
                header("Location: bazaProdukty.php");
            }

            if (isset($_POST["delete"])) {
                $id = $_POST["productId"];
                $zapytanie = "DELETE FROM `products` WHERE Id=$id";

                $wynik = mysqli_query($baza, $zapytanie);

                if (!$wynik)
                    echo "<h2>Nie udało się usunąć produktu</h2>";
                else
                    header("Location: bazaProdukty.php");
            }
                
            if (isset($_POST["updateProduct"])) {
                $id = $_POST["productId"];
                $name = $_POST["productName"];
                $price = $_POST["productPrice"];
                $desc = $_POST["productDesc"];
                $image = $_POST["productImg"];

                $zapytanie = "UPDATE `products` SET Name='$name', Price='$price', Description='$desc', Image='$image' WHERE Id=$id";

                $wynik = mysqli_query($baza, $zapytanie);
                mysqli_close($baza);

                if (!$wynik)
                    echo "Nie można zapisać zmian w edycji!";
                else
                    header("Location: index.php?id=editProduct", false);
            }
        }
    }

    function displayEditProductForm($wynik) {
        $produkt = mysqli_fetch_array($wynik);

        echo 
        "<form method='POST' name='editProductForm' id='editProductForm'>
            <input type='text' value='".$produkt["Name"]."' class='productName editProductInput' placeholder='".$produkt["Name"]."' name='productName'>
            <br>
            <input type='number' value='".$produkt["Price"]."' class='productPrice editProductInput' placeholder='".$produkt["Price"]."' name='productPrice'>
            <br>
            <textarea value='".$produkt["Description"]."' name='productDesc' class='productDesc editProductInput' placeholder='".$produkt["Description"]."' rows='7' cols='40'>".$produkt["Description"]."</textarea>
            <br>
            <input type='text' value='".$produkt["Image"]."' name='productImg' class='productImg editProductInput' placeholder='".$produkt["Image"]."'>
            <br>
            <input type='hidden' value='".$produkt["Id"]."' name='productId'>
            <button type='submit' name='updateProduct'>Zaktualizuj</button>
            <button type='submit' name='delete'>Usuń produkt</button>
            <button type='submit' name='cancel'>Anuluj</button>
        </form>";
    }

?>