<?php

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
        $id = @$_GET["id"];

        $zapytanie = "SELECT * from `comments` WHERE Id=$id";

        $wynik = mysqli_query($baza, $zapytanie);

        if (!$wynik)
            echo "<h1>Nie znaleziono podanego komentarza</h1>";
        else {
            echo "<div id='komentarzeEditDiv'>";

            while ($komentarz = mysqli_fetch_array($wynik)) {
                echo '<form method="POST" name="editComment">
                <input type="text" name="author" placeholder="'.$komentarz["Author"].'" value="'.$komentarz["Author"].'">
                <br>
                <textarea placeholder="'.$komentarz["Content"].'" value="'.$komentarz["Content"].'" name="komentarzContent" rows="4" cols="50">'.$komentarz["Content"].'</textarea>
                <input type="hidden" value="'.$komentarz["Id"].'" name="id">
                <br>
                <button type="submit" name="editComment">Zapisz zmiany</button>
                <button type="submit" name="delete">Usuń komentarz</button>
                <button type="submit" name="cancelCommentEditing">Anuluj</button>';
            }

            echo "</div>";

            if (isset($_POST["cancelCommentEditing"])) {
                mysqli_close($baza);
                header("Location: opinie.php");
            }

            if (isset($_POST["delete"])) {
                $id = $_POST["id"];
                $zapytanie = "DELETE FROM `comments` WHERE Id=$id";

                $wynik = mysqli_query($baza, $zapytanie);

                if (!$wynik)
                    echo "<h2>Nie udało się usunąć komentarza</h2>";
                else 
                    header("Location: opinie.php");
            }

            if (isset($_POST["editComment"])) {
                $author = $_POST["author"];
                $content = $_POST["komentarzContent"];
                $id = $_POST["id"];

                $zapytanie = "SELECT * FROM `profile` WHERE UserName LIKE '$author'";

                $wynik = mysqli_query($baza, $zapytanie);

                if (!$wynik) {
                    echo "<h2>Nie można zmienić autora</h2>";
                    mysqli_close($baza);
                }
                else {
                    $user = mysqli_fetch_array($wynik);

                    $zapytanie = "UPDATE `comments` SET Author='$author', Content='".$content."', UserId='".$user["Id"]."' WHERE Id=$id";

                    $wynik = mysqli_query($baza, $zapytanie);
                    mysqli_close($baza);

                    if (!$wynik)
                        echo "<h1>Nie udało się zapisać zmian.</h1>";
                    else 
                        header("Location: opinie.php");
                }
            }
        }
    }

?>