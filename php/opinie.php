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

    echo "<a href='index.php' class='goBack'><img src='../img/arrow.png' alt='arrow' class='goBack'></a>";

    if (mysqli_connect_errno())
        echo "Nie można nawiązać połączenia z bazą danych!";
    else {
        $zapytanie = "SELECT * from `comments`";

        $wynik = mysqli_query($baza, $zapytanie);
        mysqli_close($baza);

        if (!$wynik)
            echo "<h1>Brak komentarzy</h1>";
        else {
            echo "<br><br>";
            echo "<div id='dodajOpinieDiv'>";
            echo '<button class="dodajOpinieButton"><a href="dodajKomentarz.php">Dodaj komentarz</a></button>';
            echo "</div>";
            echo "<br><br>";
            echo "<div id='komentarzeDiv'>";

            while ($komentarz = mysqli_fetch_array($wynik)) {
                echo '<form method="POST" name="editComment" class="Form">
                <input type="text" name="author" placeholder="'.$komentarz["Author"].'" class="no-outline">
                <br>
                <br>
                <textarea name="komentarzContent" rows="4" cols="50" class="Textarea no-outline">'.$komentarz["Content"].'</textarea>
                <br>
                <br>
                <input type="hidden" value="'.$komentarz["Id"].' name="Id">';
                
                if (isset($_SESSION["role"])) {
                    if ($_SESSION["role"] == 1 || $_SESSION["role"] == 2) {
                        echo '<button type="submit" name="editComment" class="dodajOpiniebutton"><a href="opinieEdycja.php?id='.$komentarz["Id"].'">Edytuj</a></button>';
                    }
                }

                echo '</form>';
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