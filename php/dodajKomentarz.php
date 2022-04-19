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

    echo "<a href='opinie.php' class='goBack'><img src='../img/arrow.png' alt='arrow' class='goBack'></a>";

    if (mysqli_connect_errno())
        echo "Nie można nawiązać połączenia z bazą danych!";
    else {
        echo '<form method="POST" name="addCommentForm" class="Form">
        <h2 style="color:white; font-family:ReadexPro";font-weight:bold;text-align:center;margin-left:40%;">Treść:</h2>
        <textarea name="content" cols="50" rows="5" class="Textarea no-outline" style="margin-top:3em;height:20em;"></textarea>
        <br><br>
        <button type="submit" name="addComment" id="dodajOpinieButton" style="margin-left:30%;margin-right:40%;width:20%;">Dodaj</button>
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

<footer>
        <p>Copyright &copy; <a href="https://github.com/gal0wsky">Maciej Gawłowski</a> 2022</p>
    </footer>
</body>

</html>