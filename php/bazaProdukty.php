<?php 

function getProducts() {
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
            echo "<div>";
            while ($produkt = mysqli_fetch_array($wynik)) {
                echo "<form class=\"productsPageForm\">";
                echo "<p class=\"productName\">".$produkt["Name"]."</p><br><p class=\"productPrice\">Cena: ".$produkt["Price"]." zł</p><br><p class=\"productDesc\">".$produkt["Description"]."</p><br><img class=\"productImg\"src='../img/".$produkt["Image"]."'></img>";
                echo "<input type='hidden' value'".$produkt["Id"]."'>";
                echo "<button type='submit' name='order'>Kup</button>";
                echo "</form>";
            }
            echo "</div>";

            // if (isset($_POST["order"])) {
            //     // Buying product page
            // }
        }
    }
}

?>