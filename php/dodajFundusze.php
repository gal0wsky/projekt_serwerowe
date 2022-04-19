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

    include_once("databaseUtilities.php");

    $json = file_get_contents("../resources/login.json");
    $json = json_decode($json, true);

    $profile = getDatabaseConnectionProfile("local");

    $dbName = $profile["databaseName"];
    $dbUser = $profile["mysqlUsername"];
    $dbPassword = $profile["password"];
    $dbHostname = $profile["mysqlHostname"];

    $baza = mysqli_connect($dbHostname, $dbUser, $dbPassword, $dbName);

    echo "<a href='koszyk.php' class='goBack'><img src='../img/arrow.png' alt='arrow' class='goBack'></a>";

    if (mysqli_connect_errno())
        echo "<h2>Nie udało się połączyć z bazą danych. Spróbuj ponownie.</h2>";
    else {
        $id = @$_GET["id"];

        echo '<form method="POST" class="Form">
            <p>Dodaj fundusze (PLN)</p>
            <input type="number" name="kwota" class="no-outline">
            <br>
            <button type="submit" name="send" style="margin-top:2em;margin-left:15%;margin-right:35%;width:30%;">Dodaj fundusze</button>
        </form>';

        if (array_key_exists("send", $_POST)) {
            if (isset($_POST["send"])) {
                $kwota = $_POST["kwota"];

                if ($kwota < 0.00)
                    echo "<h3>Nie można dodać funduszy!</h3>";
                else {
                    $zapytanie = "SELECT * FROM `shoppingcard` WHERE Id=".$_SESSION["userShoppingCard"];
                    $koszyk = mysqli_fetch_array(mysqli_query($baza, $zapytanie));

                    $koszyk["Cash"] += $kwota;

                    $zapytanie = "UPDATE `shoppingcard` SET Cash='".$koszyk["Cash"]."'";

                    $wynik = mysqli_query($baza, $zapytanie);

                    if (!$wynik)
                        echo "<h3>Nie można dodać funduszy!</h3>";
                    else 
                        header("Location: koszyk.php");
                }
            }
        }
    }
?>

<footer>
        <p>Copyright &copy; <a href="https://github.com/gal0wsky">Maciej Gawłowski</a> 2022</p>
    </footer>
</body>

</html>