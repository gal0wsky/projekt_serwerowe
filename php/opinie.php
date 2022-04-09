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

    if (mysqli_connect_errno())
        echo "Nie można nawiązać połączenia z bazą danych!";
    else {
        $zapytanie = "SELECT * from `comments`";

        $wynik = mysqli_query($baza, $zapytanie);
        mysqli_close($baza);

        if (!$wynik)
            echo "<h1>Brak komentarzy</h1>";
        else {
            echo "<div id='komentarzeDiv'>";

            while ($komentarz = mysqli_fetch_array($wynik)) {
                echo '<form method="POST" name="editComment">
                <input type="text" name="author" placeholder="'.$komentarz["Author"].'">
                <br>
                <textarea name="komentarzContent" rows="4" cols="50">
                    '.$komentarz["Content"].'
                </textarea>
                <br>
                <input type="hidden" value="'.$komentarz["Id"].' name="Id">';
                
            

                if (isset($_SESSION["role"])) {
                    if ($_SESSION["role"] == 1 || $_SESSION["role"] == 2) {
                        echo '<button type="submit" name="editComment"><a href="opinieEdycja.php?id='.$komentarz["Id"].'">Edytuj</a></button>';
                    }
                }

                echo '</form>';
            }

            echo "</div>";
        }
    }

?>