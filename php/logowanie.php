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

    include_once("databaseUtilities.php");

    session_start();

    $profile = getDatabaseConnectionProfile("local");
    
    $dbName = $profile["databaseName"];
    $dbUser = $profile["mysqlUsername"];
    $dbPassword = $profile["password"];
    $dbHostname = $profile["mysqlHostname"];
    
    $baza = mysqli_connect($dbHostname, $dbUser, $dbPassword, $dbName);

    echo "<a href='index.php' class='goBack'><img src='../img/arrow.png' alt='arrow' class='goBack'></a>";

    echo '<div id="loginFormDiv">';

    echo 
    '<h1>Logowanie</h1>
    <form method="POST" name="loginForm" class="Form">
        <p>Login:</p>
        <input type="text" name="login" class="no-outline">
        <br>
        <p>Hasło:</p>
        <input type="password" name="password" class="no-outline">
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
                $zapytanie = "SELECT * FROM `profiles` WHERE UserName LIKE '$login' AND Password LIKE '$password'";
                
                $wynik = mysqli_query($baza, $zapytanie);

                if ($wynik) {
                    $user = mysqli_fetch_array($wynik);

                    $_SESSION["user"] = $user["UserName"];
                    $_SESSION["role"] = $user["Role"];
                    $_SESSION["userId"] = $user["Id"];
                    $_SESSION["userShoppingCard"] = $user["ShoppingCard"];

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
        
            $users = mysqli_num_rows(mysqli_query($baza, "SELECT * FROM `profiles` WHERE UserName LIKE '$login' AND Password LIKE '$pass'"));
        
            mysqli_close($baza);

            if ($users == 0) {
                return false;
            }
        
            echo '</div>';
        
            return true;
        
        }
    }

?>

    <footer>
        <p>Copyright &copy; <a href="https://github.com/gal0wsky">Maciej Gawłowski</a> 2022</p>
    </footer>
</body>

</html>