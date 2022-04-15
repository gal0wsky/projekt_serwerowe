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
    } else {
        $zapytanie = "SELECT * FROM `products`";
    
        $wynik = mysqli_query($baza, $zapytanie);
    
        $ile = mysqli_num_rows($wynik);
    
        if ($ile <= 0)
            echo "Nie znaleziono żadnych produktów.";
        else {
            echo '<a href="index.php"><button type="button">Wróć</button></a>';

            if (isset($_SESSION["role"])) {
                if ($_SESSION["role"] == 1 || $_SESSION["role"] == 2)
                    echo "<button><a href='dodajProdukt.php'>Dodaj produkt</a></button>";
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
                        echo "<button type='submit' name='order'><a href='kupProdukt.php?id=".$produkt["Id"]."'>Kup</a></button>";

                    if ($_SESSION["role"] == 1 || $_SESSION["role"] == 2) {
                        echo "<button type='submit' name='editProduct'><a href='edycjaProduktu.php?id=".$produkt["Id"]."'>Edytuj</a></button>";
                    }
                }

                echo "</form>";
                echo "<br><br><br><br><br><br><br><br><br>";
            }
            echo "</div>";
        }
    }

?>