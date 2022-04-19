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

    include_once("databaseUtilities.php");

    $json = file_get_contents("../resources/login.json");
    $json = json_decode($json, true);

    $profile = getDatabaseConnectionProfile("remote");

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
        "<form method='POST' name='editProductForm' id='editProductForm' class='Form'>
            <input type='text' value='".$produkt["Name"]."' class='productName editProductInput no-outline' placeholder='".$produkt["Name"]."' name='productName'>
            <br>
            <br>
            <input type='number' value='".$produkt["Price"]."' class='productPrice editProductInput no-outline' placeholder='".$produkt["Price"]."' name='productPrice'>
            <br>
            <br>
            <textarea value='".$produkt["Description"]."' name='productDesc' class='productDesc editProductInput no-outline Textarea' placeholder='".$produkt["Description"]."' rows='7' cols='40'>".$produkt["Description"]."</textarea>
            <br>
            <br>
            <input type='text' value='".$produkt["Image"]."' name='productImg' class=' editProductInput no-outline' placeholder='".$produkt["Image"]."'>
            <br>
            <br>
            <input type='hidden' value='".$produkt["Id"]."' name='productId'>
            <button type='submit' name='updateProduct'>Zaktualizuj</button>
            <button type='submit' name='delete'>Usuń produkt</button>
            <button type='submit' name='cancel'>Anuluj</button>
        </form>";
    }

?>

<footer>
        <p>Copyright &copy; <a href="https://github.com/gal0wsky">Maciej Gawłowski</a> 2022</p>
    </footer>
</body>

</html>