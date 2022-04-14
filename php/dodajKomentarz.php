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
        echo '<form method="POST" name="addCommentForm">
        <h2>Treść:</h2>
        <textarea name="content" cols="50" rows="5"></textarea>
        <br><br>
        <button type="submit" name="addComment">Dodaj</button>
        </form>';

        if (array_key_exists("addComment", $_POST)) {
            if (isset($_POST["addComment"])) {
                $content = $_POST["content"];
                $author = $_SESSION["user"];
                $userID = $_SESSION["userId"];

                $zapytanie = "INSERT INTO `comments` (UserId, Content, Author) VALUES ('$userID', '$content', '$author')";

                $wynik = mysqli_query($baza, $zapytanie);

                if (!$wynik)
                    echo "<h2>Nie udało się dodać komentarza</h2>";
                else
                    header("Location: opinie.php");
            }
        }
    }

?>

