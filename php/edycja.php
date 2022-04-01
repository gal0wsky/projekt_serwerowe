<html>
    <head>
    <link rel="stylesheet" href="../css/index.css?v=<?php echo time(); ?>">
    </head>

<div id="editProductDiv">

<?php 

// echo '<form method="GET" name="findProductToEdit" id="findProductToEdit">
// <input type="number" name="id" placeholder="ID Produktu:">
// <br>
// <br>
// <button type="submit" name="findProductToEdit" id="findProductToEdit">Wyszukaj produkt</button>
// </form>';

// if (array_key_exists("findProductToEdit", $_GET)) {
//     getProductToEdit();
// }

// if (array_key_exists("updateProduct", $_POST))
//     editProduct();

// getAllProducts();

function getProductToEdit() {
    // $id=2;
    $baza = mysqli_connect("localhost", "root", "", "yesmed_database");

    if (mysqli_connect_errno())
        echo "Coś poszło nie tak :(";
    else {
        if (!isset($_GET["findProductToEdit"]))
            echo "Błąd formularza";
        else {
            $id = $_GET["id"];
            $zapytanie = "SELECT * FROM `products` WHERE Id='$id'";

            $wynik = mysqli_query($baza, $zapytanie);

            if (!$wynik) {
                echo "Nie znaleziono produktu!";
            }
            else {
                displayEditProductForm($wynik);
            }   
        }
    }
    mysqli_close($baza);
}

function editProduct() {
    $baza = mysqli_connect("localhost", "root", "", "yesmed_database");

    if (mysqli_connect_errno())
        echo "<h4>Błąd połączenia z bazą danych!</h4>";
    else {
        if (!isset($_POST["updateProduct"]))
            echo "Coś poszło nie tak :(";
        else {
            $productId = $_POST["id"];
            $name = $_POST["productName"];
            $price = $_POST["productPrice"];
            $desc = $_POST["productDesc"];
            $image = $_POST["productImg"];

            $zapytanie = "UPDATE `products` SET Name='$name', Price='$price', Description='$desc', Image='$image' WHERE Id=$productId";

            $wynik = mysqli_query($baza, $zapytanie);

            if (!$wynik)
                echo "<h3>Coś poszło nie tak w trakcie aktualizacji danych :(</h3>";
            else {
                echo "<h3>Produkt zaktualizowany pomyślnie</h3>";
            }
        }
    }

    mysqli_close($baza);
}

function getAllProducts() {
    $baza = mysqli_connect("localhost", "root", "", "yesmed_database");

    if (mysqli_connect_errno())
        echo "<h2>Nie można wczytać produktów</h2>";
    else {
        $zapytanie = "SELECT * FROM `products`";

        $wynik = mysqli_query($baza, $zapytanie);
        $ile = mysqli_num_rows($wynik);

        if ($ile < 1)
            echo "<h3>Brak produktów w bazie danych!</h3>";
        else {
            echo "<h2>Dostępne produkty:</h2><br>";
            echo "<table id='productsList'>";

            while ($produkt = mysqli_fetch_array($wynik)) {
                echo "<tr>";
                echo "<th>Nazwa: ".$produkt["Name"]."</th>";
                echo "<td>Cena: ".$produkt["Price"]."</td>";
                echo "<td><button class='editProductRedirectButton'><a href=\"edycjaProduktu.php?id=".$produkt["Id"]."\">EDYTUJ</a></button></td>";
                echo "</tr>";
            }

            echo "</table>";
        }
    }
}

?>

</div>
</html>