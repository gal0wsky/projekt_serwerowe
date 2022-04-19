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

    @session_start();

    include_once("databaseUtilities.php");

    $json = file_get_contents("../resources/login.json");
    $json = json_decode($json, true);

    $profile = getDatabaseConnectionProfile("remote");

    $dbName = $profile["databaseName"];
    $dbUser = $profile["mysqlUsername"];
    $dbPassword = $profile["password"];
    $dbHostname = $profile["mysqlHostname"];

    $baza = mysqli_connect($dbHostname, $dbUser, $dbPassword, $dbName);

    if (mysqli_connect_errno()) {
        echo "Błąd połączenia z bazą danych!";
    } else {
        $zapytanie = "SELECT * FROM `products`";
    
        $wynik = mysqli_query($baza, $zapytanie);
    
        $ile = mysqli_num_rows($wynik);
    
        if ($ile <= 0)
            echo "Nie znaleziono żadnych produktów.";
        else {
            echo "<a href='index.php' class='goBack'><img src='../img/arrow.png' alt='arrow' class='goBack'></a>";

            if (isset($_SESSION["role"])) {
                if ($_SESSION["role"] == 1 || $_SESSION["role"] == 2)
                    echo "<button id='dodajProdukt'><a href='dodajProdukt.php'>Dodaj produkt</a></button>";
            }

            echo "<br><br>";
            echo "<div>";
            while ($produkt = mysqli_fetch_array($wynik)) {
                echo "<form class=\"productsPageForm\">";

                echo "<h1 class='productName'>".$produkt["Name"]."</h1>";
                echo "<br>";
                echo "<h3 class='productPrice'>Cena: ".$produkt["Price"]." zł</h3>";
                echo "<br>";
                echo "<h4 class='productDesc'>".$produkt["Description"]."</h4>";
                echo "<br>";
                echo "<img class='productImg' src='../img/".$produkt["Image"]."'></img>";

                echo "<input type='hidden' value'".$produkt["Id"]."' name='productId'>";

                if (isset($_SESSION["role"])) {
                    if ($_SESSION["role"] == 3)
                        echo "<button type='submit' name='order' class='editProductButton'><a href='kupProdukt.php?id=".$produkt["Id"]."'>Kup</a></button>";

                    if ($_SESSION["role"] == 1 || $_SESSION["role"] == 2) {
                        echo "<button type='submit' name='editProduct' class='editProductButton'><a href='edycjaProduktu.php?id=".$produkt["Id"]."'>Edytuj</a></button>";
                    }
                }

                echo "</form>";
                echo "<br><br><br><br><br><br><br><br><br>";
            }
            echo "</div>";
        }
    }

?>

<footer>
        <p>Copyright &copy; <a href="https://github.com/gal0wsky">Maciej Gawłowski</a> 2022</p>
    </footer>
</body>

</html>