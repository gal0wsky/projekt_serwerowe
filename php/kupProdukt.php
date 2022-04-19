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

    echo "<a href='bazaProdukty.php' class='goBack'><img src='../img/arrow.png' alt='arrow' class='goBack'></a>";
    echo "<br><br>";

    $id = @$_GET["id"];

    include_once("databaseUtilities.php");

    $json = file_get_contents("../resources/login.json");
    $json = json_decode($json, true);

    $profile = getDatabaseConnectionProfile("remote");

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

            echo '<form method="POST" class="Form" id="kupProduktForm">
                <h1 class="productName">'.$produkt["Name"].'</h1>
                <br>
                <h3 class="productDesc">Opis:</h3>
                <p class="productDesc">'.$produkt["Description"].'</p>
                <br>
                <h3 class="productDesc" style="margin-top:3em;margin-bottom: 1em;">Ilość:</h3>
                <input type="number" name="amount" class="no-outline">
                <br><br>
                <button type="submit" name="order">Dodaj do koszyka</button>
            </form>';
            echo "<br><br>";
            echo "<img class='productImg kupProduktImg' src='../img/".$produkt["Image"]."' alt='".$produkt["Image"]."'></img>";

            if (array_key_exists("order", $_POST)) {
                if (isset($_POST["order"])) {
                    $ilosc = $_POST["amount"];
                    
                    $zapytanie = "INSERT INTO `productslists` (ShoppingCardId, ProductId, Amount) VALUES((SELECT Id FROM `shoppingcard` WHERE UserId=".$_SESSION["userId"]."), (SELECT Id FROM `products` WHERE Id=$id), $ilosc)";
                    $wynik = mysqli_query($baza, $zapytanie);
                    mysqli_close($baza);

                    if (!$wynik)
                        echo "<h2 class='Error'>Nie można dodać produktu do koszyka.</h2>";
                    else 
                        header("Location: bazaProdukty.php");
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