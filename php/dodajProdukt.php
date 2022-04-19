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
    } 
    else {
        echo '<form method="POST" class="Form">
            <p>Nazwa:</p>
            <input type="text" name="name" class="no-outline">
            <p>Cena:</p>
            <input type="number" step="any" name="price" class="no-outline">
            <p>Opis:</p>
            <textarea name="desc" cols="50" rows="10" class="Textarea no-outline"></textarea>
            <p>Grafika:</p>
            <input type="text" name="image" class="no-outline">
            <div class="buttons" id="dodajProduktButtonsDiv">
            <button type="submit" name="send">Dodaj</button>
            <button><a href="bazaProdukty.php">Anuluj</a></button>
            </div>
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

<footer>
        <p>Copyright &copy; <a href="https://github.com/gal0wsky">Maciej Gawłowski</a> 2022</p>
    </footer>
</body>

</html>