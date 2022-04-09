<?php

    include_once("databaseUtilities.php");

    session_start();

    $profile = getDatabaseConnectionProfile("local");
    
    $dbName = $profile["databaseName"];
    $dbUser = $profile["mysqlUsername"];
    $dbPassword = $profile["password"];
    $dbHostname = $profile["mysqlHostname"];
    
    $baza = mysqli_connect($dbHostname, $dbUser, $dbPassword, $dbName);

    echo '<div id="loginFormDiv">';

    echo 
    '<h1>Logowanie</h1>
    <form method="POST" name="loginForm">
        <p>Login:</p>
        <input type="text" name="login">
        <br>
        <p>Hasło:</p>
        <input type="password" name="password">
        <br><br>
        <button type="submit" name="signin">Zaloguj</button>
    </form>';

    if (mysqli_connect_errno()) {
        echo "<h1>Wystąpił błąd połączenia z bazą</h1>";
    } else {
        if (isset($_POST["signin"])) {
            $login = @$_POST["login"];
            $password = md5(@$_POST["password"]);

            if (!canSignIn($login, $password))
                echo '<h1 id="cannotLogin">Nie można zalogować!</h1>';
            else {
                $zapytanie = "SELECT * FROM `profile` WHERE UserName LIKE '$login' AND Password LIKE '$password'";
                
                $wynik = mysqli_query($baza, $zapytanie);

                if ($wynik) {
                    $user = mysqli_fetch_array($wynik);

                    $_SESSION["user"] = $user["UserName"];
                    $_SESSION["role"] = $user["Role"];
                    header("Location: index.php");
                }

                mysqli_close($baza);
            }
        }
    }
    echo '</div>';


function canSignIn($login, $pass) {
    $profile = getDatabaseConnectionProfile("local");
    
    $dbName = $profile["databaseName"];
    $dbUser = $profile["mysqlUsername"];
    $dbPassword = $profile["password"];
    $dbHostname = $profile["mysqlHostname"];
    
    $baza = mysqli_connect($dbHostname, $dbUser, $dbPassword, $dbName);
    
    if (mysqli_connect_errno()) {
        echo "<h1>Błąd połączenia z bazą danych!</h1>";
    }
    else {
        echo '<div id="loginDataVerificationDiv">';
    
        $users = mysqli_num_rows(mysqli_query($baza, "SELECT * FROM `profile` WHERE UserName LIKE '$login' AND Password LIKE '$pass'"));
    
        mysqli_close($baza);

        if ($users == 0) {
            return false;
        }
    
        echo '</div>';
    
        return true;
    
        }
    }

?>