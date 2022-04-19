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

    include_once("databaseUtilities.php");

    $json = file_get_contents("../resources/login.json");
    $json = json_decode($json, true);

    $profile = getDatabaseConnectionProfile("local");

    $dbName = $profile["databaseName"];
    $dbUser = $profile["mysqlUsername"];
    $dbPassword = $profile["password"];
    $dbHostname = $profile["mysqlHostname"];

    $baza = mysqli_connect($dbHostname, $dbUser, $dbPassword, $dbName);

    echo "<a href='zarzadzajUzytkownikami.php' class='goBack'><img src='../img/arrow.png' alt='arrow' class='goBack'></a>";

    if (mysqli_connect_errno())
        echo "<h2>Nie można nawiązać połączenia z bazą danych.</h2>";
    else {
        $id = @$_GET["id"];

        $zapytanie = "SELECT * FROM `profiles` WHERE Id=$id";

        $wynik = mysqli_query($baza, $zapytanie);

        if (!$wynik) {
            mysqli_close($baza);
            echo "<h2>Nie można pobrać danych użytkownika z bazy danych.</h2>";
        }
        else {
            $user = mysqli_fetch_array($wynik);

            echo '<form method="POST" class="Form">
                <p>Login:</p>
                <input type="text" placeholder="'.$user["UserName"].'" value="'.$user["UserName"].'" name="username" class="no-outline">
                <p>E-mail:</p>
                <input type="email" placeholder="'.$user["Email"].'" value="'.$user["Email"].'" name="email" class="no-outline">
                <p>Rola:</p>
                <input type="text" placeholder="'.$user["Role"].'" value="'.$user["Role"].'" name="role" class="no-outline">
                <p>Stan portfela:</p>
                <input type="number" placeholder="'.$user["Cash"].'" value="'.$user["Cash"].'" name="cash" class="no-outline">
                <p>Adres:</p>
                <input type="text" placeholder="'.$user["Address"].'" value="'.$user["Address"].'" name="adres" class="no-outline">
                <input type="hidden" value="'.$user["Id"].'" name="id">
                <br><br>
                <button type="submit" name="update">Zastosuj</button>
                <button><a href="zarzadzajUzytkownikami.php">Anuluj</a></button>
            </form>';

            if (isset($_POST["update"])) {
                $id = $_POST["id"];
                $username = $_POST["username"];
                $email = $_POST["email"];
                $role = $_POST["role"];
                $cash = $_POST["cash"];
                $address = $_POST["adres"];

                $zapytanie = "UPDATE `profiles` SET UserName='$username', Email='$email', Role='$role', Cash='$cash', Address='$address' WHERE Id=$id";

                $wynik = mysqli_query($baza, $zapytanie);
                mysqli_close($baza);

                if (!$wynik) 
                    echo "<h2>Nie można zapisać zmian.</h2>";
                else 
                    header("Location: zarzadzajUzytkownikami.php");
            }
        }
    }

?>

<footer>
        <p>Copyright &copy; <a href="https://github.com/gal0wsky">Maciej Gawłowski</a> 2022</p>
    </footer>
</body>

</html>