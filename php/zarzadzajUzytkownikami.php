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
        echo "<h2>Nie można nawiązać połączenia z bazą danych.</h2>";
    else {
        $zapytanie = "SELECT * FROM `profiles`";

        $wynik = mysqli_query($baza, $zapytanie);

        if (!$wynik) 
            echo "<h2>Nie można pobrać listy użytkowników.</h2>";
        else {
            echo "<button><a href='index.php'>Wróć</a></button>";
            echo "<br>";

            echo "<h2>Lista użytkowników:</h2>";
            echo "<ul>";

            while ($user = mysqli_fetch_array($wynik)) {
                if ($user["UserName"] != "Root") {
                    echo "<li class='manageUserListRecord'>";
                    echo '<form method="POST">
                        <h3>'.$user["UserName"].'</h3>
                        <input type="hidden" value="'.$user["Id"].'" name="id">
                        <input type="hidden" value="'.$user["UserName"].'" name="login">
                        <input type="hidden" value="'.$user["ShoppingCard"].'" name="shoppingCard">
                        <button class="manageUserButton" name="manage">Zarządzaj</button>
                        <button class="manageUserButton" name="delete">Usuń</button>
                    </form>';

                    if (isset($_POST["manage"])) {
                        mysqli_close($baza);
                        header("Location: uzytkownik.php?id=".$user["Id"]);
                    }
        
                    if (isset($_POST["delete"])) {
                        $id = $_POST["id"];
                        $login = $_POST["login"];
                        $shoppingCard = $_POST["shoppingCard"];

                        $zapytanie = "DELETE FROM `productslists` WHERE ShoppingCardId=$shoppingCard";
        
                        $wynik = mysqli_query($baza, $zapytanie);
        
                        if (!$wynik)
                            echo "Nie można usunąć zamówień użytkownika ".$user["UserName"];
                        else {
                            $zapytanie = "DELETE FROM `shoppingcard` WHERE UserId=$id";
        
                            $wynik = mysqli_query($baza, $zapytanie);
        
                            if (!$wynik) {
                                mysqli_close($baza);
                                echo "Nie można usunąć koszyka użytkownika $login";
                            }
                            else {
                                $zapytanie = "DELETE FROM `profiles` WHERE Id=$id";
        
                                $wynik = mysqli_query($baza, $zapytanie);
        
                                if (!$wynik) {
                                    mysqli_close($baza);
                                    echo "Nie można usunąć użytkownika $login";
                                }
                                else {
                                    mysqli_close($baza);
                                    header("Location: zarzadzajUzytkownikami.php");
                                }
                            }
                        }
                    }
                }
                echo "</li>";
            }
            echo "</ul>";
        }
    }

?>