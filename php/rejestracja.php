<?php

$json = file_get_contents("../login.json");
$json = json_decode($json, true);

$dbName = $json["databaseName"];
$dbUser = $json["mysqlUsername"];
$dbPassword = $json["password"];
$dbHostname = $json["mysqlHostname"];


function rejestracjaForm() {
    echo '
    <div class="bazaForm">
        <form action="" method="POST">
            <h2>Login:</h2>
            <input type="text" name="login">
            <br>
            <h2>Hasło:</h2>
            <input type="password" name="pass">
            <br>
            <input type="submit" name="signin" value="Zarejestruj">
        </form>
    </div>
    ';
}

if (array_key_exists("signin", $_POST))
    zarejestroj();

function zarejestroj() {
    echo '<div id="zarejestrojFunctionContent">';
    // $baza = mysqli_connect($dbHostname, $dbUser, $dbPassword, $dbName);

    $baza = mysqli_connect("localhost", "root", "", "projekt");

    if (mysqli_connect_errno()) {
        echo "<h1>Wystąpił błąd połączenia z bazą</h1>";
    } else {
        if (!isset($_POST["signin"])) {
            echo "<h1>Błąd formularza!</h1>";
        } else {
            $login = @$_POST["login"];
            $password = @$_POST["pass"];

            if (!canRegister($login, $password))
                echo '<h1 id="cannotRegister">Nie można zarejestrować!</h1>';
            else {
                $zapytanie = "INSERT INTO `users` (user, pass) VALUES ('$login', '$password')";
                $wynik = mysqli_query($baza, $zapytanie);

                echo '<div id="bazaContent">';
                echo '<p id="rejestracjaResult">';

                if ($wynik)
                    echo "Rejestracja przebiegła pomyślnie";
                else
                    echo "Coś poszło nie tak :(";

                echo '</p>';
                echo '</div>';

                $users = mysqli_query($baza, "SELECT * FROM `users`");
                $ile = mysqli_num_rows($users);

                echo '<div id="usersList"><h1>W bazie mam ' . $ile . ' użytkowników:</h1><br>';
                while ($wiersz = mysqli_fetch_array($users)) {
                    echo "<p>•\t" . $wiersz[0] . "</p>";
                }
                echo "</div>";
                mysqli_close($baza);
            }
        }
    }
    echo '</div>';
}

function canRegister($login, $pass) {
    // $baza = mysqli_connect($dbHostname, $dbUser, $dbPassword, $dbName);

    $baza = mysqli_connect("localhost", "root", "", "projekt");

    if (mysqli_connect_errno()) {
        echo "<h1>Błąd połączenia z bazą danych!</h1>";
    }
    else {

        echo '<div id="userInputVerification">';

        $users = mysqli_fetch_array(mysqli_query($baza, "SELECT * FROM `users` WHERE user = '$login'"));

        if ($users != 0) {
            echo "<h2>Login zajęty!</h2>";
            return false;
        }
        else if ($pass == "") {
            echo "<h2>Hasło nie może być puste!</h2>";
            return false;
        }

        mysqli_close($baza);

        echo '</div>';

        return true;

    }
}
?>