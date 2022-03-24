<?php 

function getProducts() {
    $baza = mysqli_connect("localhost", "root", "", "yesmed_database");

    if (mysqli_connect_errno()) {
        echo "Błąd połączenia z bazą danych!";
    } else {
        $zapytanie = "SELECT * FROM `Products`";
    
        $wynik = mysqli_query($baza, $zapytanie);
    
        $ile = mysqli_num_rows($wynik);
    
        if ($ile <= 0)
            echo "Nie znaleziono żadnych produktów.";
        else {
            echo "<div id=\"productsList\">";
            while ($wiersz = mysqli_fetch_array($wynik)) {
                echo "<div class=\"productsDiv\">";
                echo "<p class=\"productName\">".$wiersz["Name"]."</p><br><p class=\"productPrice\">Cena: ".$wiersz["Price"]." zł</p><br><p class=\"productDesc\">".$wiersz["Description"]."</p><br><p class=\"productImg\">".$wiersz["Image"]."</p>";
                echo "</div>";
            }
            echo "</div>";
        }
    }
}

?>