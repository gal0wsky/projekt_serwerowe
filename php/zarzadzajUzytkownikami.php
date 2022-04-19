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

    <?php
    include("towary.php");
    include("zgloszenie.php");
    include("regex.php");
    include("baza.php");
    ?>
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

    echo "<a href='index.php' class='goBack'><img src='../img/arrow.png' alt='arrow' class='goBack'></a>";

    if (mysqli_connect_errno())
        echo "<h2>Nie można nawiązać połączenia z bazą danych.</h2>";
    else {
        $zapytanie = "SELECT * FROM `profiles`";

        $wynik = mysqli_query($baza, $zapytanie);

        if (!$wynik) 
            echo "<h2>Nie można pobrać listy użytkowników.</h2>";
        else {
            echo "<br>";

            echo "<h2 style='color:white;text-align:center;'>Lista użytkowników:</h2>";
            echo "<ul>";

            while ($user = mysqli_fetch_array($wynik)) {
                if ($user["UserName"] != "Root") {
                    echo "<li class='manageUserListRecord'>";
                    echo '<form method="POST" class="Form">
                        <h3 style="color:white;margin-bottom:1em;">'.$user["UserName"].'</h3>
                        <input type="hidden" value="'.$user["Id"].'" name="id" class="no-outline">
                        <input type="hidden" value="'.$user["UserName"].'" name="login" class="no-outline">
                        <input type="hidden" value="'.$user["ShoppingCard"].'" name="shoppingCard" class="no-outline">
                        <button class="manageUserButton" name="manage">Zarządzaj</button>
                        <button class="manageUserButton" name="delete">Usuń</button>
                    </form>';

                    if (isset($_POST["manage"])) {
                        mysqli_close($baza);
                        header("Location: uzytkownik.php?id=".$user["Id"]);
                    }
        
                    if (isset($_POST["delete"])) {
                        $id = $_POST["id"];
                        $login = $_POST["login"];
                        $shoppingCard = $_POST["shoppingCard"];

                        $zapytanie = "DELETE FROM `productslists` WHERE ShoppingCardId=$shoppingCard";
        
                        $wynik = mysqli_query($baza, $zapytanie);
        
                        if (!$wynik)
                            echo "Nie można usunąć zamówień użytkownika ".$user["UserName"];
                        else {
                            $zapytanie = "DELETE FROM `shoppingcard` WHERE UserId=$id";
        
                            $wynik = mysqli_query($baza, $zapytanie);
        
                            if (!$wynik) {
                                mysqli_close($baza);
                                echo "Nie można usunąć koszyka użytkownika $login";
                            }
                            else {
                                $zapytanie = "DELETE FROM `profiles` WHERE Id=$id";
        
                                $wynik = mysqli_query($baza, $zapytanie);
        
                                if (!$wynik) {
                                    mysqli_close($baza);
                                    echo "Nie można usunąć użytkownika $login";
                                }
                                else {
                                    mysqli_close($baza);
                                    header("Location: zarzadzajUzytkownikami.php");
                                }
                            }
                        }
                    }
                }
                echo "</li>";
            }
            echo "</ul>";
        }
    }

?>

<footer>
        <p>Copyright &copy; <a href="https://github.com/gal0wsky">Maciej Gawłowski</a> 2022</p>
    </footer>
</body>

</html>