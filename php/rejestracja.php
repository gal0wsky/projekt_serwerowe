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


    echo '
    <div class="rejestracjaForm">
        <form action="" method="POST">
            <p>Login:</p>
            <input type="text" name="login" require>
            <br>
            <p>Hasło:</p>
            <input type="password" name="password" require>
            <br>
            <p>Adres e-mail:</p>
            <input type="email" placeholder="jan.kowalski@mail.pl" name="email" require>
            <br>
            <p>Adres:</p>
            <input type="text" placeholder="00-001 Warszawa, ul. Warszawska 420" name="adres" require>
            <br>
            <button type="submit" name="signup" value="Zarejestruj">Zarejestruj</button>
            <button type="submit" name="cancel" value="Anuluj"><a href="index.php">Anuluj</a></button>
        </form>
    </div>
    ';

if (array_key_exists("signup", $_POST))
    zarejestroj();

function zarejestroj() {
    echo '<div id="rejestracjaFormDiv">';

    $json = file_get_contents("../resources/login.json");
    $json = json_decode($json, true);

    $profile = getDatabaseConnectionProfile("local");

    $dbName = $profile["databaseName"];
    $dbUser = $profile["mysqlUsername"];
    $dbPassword = $profile["password"];
    $dbHostname = $profile["mysqlHostname"];

    $baza = mysqli_connect($dbHostname, $dbUser, $dbPassword, $dbName);

    if (mysqli_connect_errno()) {
        echo "<h1>Wystąpił błąd połączenia z bazą</h1>";
    } else {
        if (isset($_POST["cancel"])) {
            header("Location: index.php");
        } if (isset($_POST["signup"])) {
            $login = @$_POST["login"];
            $password = md5(@$_POST["password"]);
            $email = @$_POST["email"];
            $address = @$_POST["adres"];

            if (!canRegister($login))
                echo "<h2>Login zajęty!</h2>";
            else {
                $regex = '/^\d{2}\-\d{3}\s\w+,\sul\.\s[\w\s]+$/';

                if (!preg_match($regex, $address))
                    echo "Niepoprawny adres!";
                else {
                    $zapytanie = "INSERT INTO `profiles` (UserName, Password, Role, Email, Address) VALUES ('$login', '$password', '3', '$email', '$address')";
                    $wynik = mysqli_query($baza, $zapytanie);

                    $zapytanie = "SELECT * FROM `profiles` WHERE UserName LIKE '".$login."'";

                    $wynik = mysqli_query($baza, $zapytanie);

                    if (!$wynik)
                        echo "<h2>Coś poszło nie tak.</h2>";
                    else {
                        $user = mysqli_fetch_array($wynik);
                        $zapytanie = "INSERT INTO `shoppingcard` SET Cash=0.00, ProductsPrice=0.00, UserId=LAST_INSERT_ID()";

                        $wynik = mysqli_query($baza, $zapytanie);

                        $zapytanie = "SELECT * FROM `shoppingcard` WHERE UserId=".$user["Id"];
                        $wynik = mysqli_query($baza, $zapytanie);

                        $koszyk = mysqli_fetch_array($wynik);

                        $zapytanie = "UPDATE `profiles` SET ShoppingCard=LAST_INSERT_ID() WHERE Id=".$user["Id"];

                        mysqli_query($baza, $zapytanie);
                    }

                    mysqli_close($baza);

                    echo '<div id="bazaContent">';
                    echo '<p id="rejestracjaResult">';

                    if ($wynik)
                        header("Location: logowanie.php");
                    else
                        echo "<h3>Wystąpił błąd w czasie rejestracji.</h3>";

                    echo '</p>';
                    echo '</div>';
                }
            }
        }
    }
    echo '</div>';
}

function canRegister($login) {
    $profile = getDatabaseConnectionProfile("local");

    $dbName = $profile["databaseName"];
    $dbUser = $profile["mysqlUsername"];
    $dbPassword = $profile["password"];
    $dbHostname = $profile["mysqlHostname"];

    $baza = mysqli_connect($dbHostname, $dbUser, $dbPassword, $dbName);

    if (mysqli_connect_errno()) {
        echo "<h1>Niepoprawne dane w formularzu!</h1>";
    }
    else {
        echo '<div id="registrationDataVerificationDiv">';

        $users = mysqli_fetch_array(mysqli_query($baza, "SELECT * FROM `profiles` WHERE UserName LIKE '$login'"));

        if ($users != 0) {
            return false;
        }

        mysqli_close($baza);

        echo '</div>';

        return true;

    }
}

function hashPassByWujekMacius($pass) {
    $newPass = $pass;

    for ($i=0; $i<13; $i++) {
        $newPass = hash("sha256", $newPass);
    }

    return $newPass;
}

?>