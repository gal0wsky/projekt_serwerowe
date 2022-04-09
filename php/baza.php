
<?php

function opinieForm() {
    echo '
    <div class="bazaForm">
        <form action="" method="POST">
            <h2>Podaj nazwę newsa:</h2>
            <input type="text" name="fraza">
            <br>
            <input type="submit" name="send" value="Szukaj">
        </form>
    </div>';
}

if (array_key_exists("send", $_POST))
    database();

function database()
{
    $json = file_get_contents("../resources/login.json");
    $json = json_decode($json, true);

    $profile = $json["local"];

    $dbName = $profile["databaseName"];
    $dbUser = $json["mysqlUsername"];
    $dbPassword = $json["password"];
    $dbHostname = $json["mysqlHostname"];

    $baza = mysqli_connect($dbHostname, $dbUser, $dbPassword, $dbName);
    // $baza = mysqli_connect("localhost", "root", "", "projekt");

    if (mysqli_connect_errno()) {
        echo "<h1>Wystąpił błąd połączenia z bazą</h1>";
    } else {
        if (!isset($_POST["send"])) {
            echo "<h1>Błąd formularza!</h1>";
        } else {
            $fraza = @"%".$_POST["fraza"]."%";

            $zapytanie = "SELECT * FROM newsy WHERE autor LIKE '" . $fraza . "' OR news LIKE '" . $fraza . "'";
            $wynik = mysqli_query($baza, $zapytanie);

            $ile = mysqli_num_rows($wynik);

            echo '<div id="bazaContent">';
            echo '<h1>W bazie mam ' . $ile . ' komentarzy:</h1><br>';

            // for ($i = 0; $i < $ile; $i++) {
            //     $wiersz = mysqli_fetch_array($wynik);
            //     echo "<p> •\t".$wiersz['news'] . ": <b>".$wiersz['author']."</b></p>";
            //     echo "<br>";
            // }

            while ($wiersz = mysqli_fetch_array($wynik)) {
                // 'Wyszukiwarka'
                echo "<p>•\t" . $wiersz[0] . "</p>";

                // Statycznie
                // echo "<p> •\t" . $wiersz['news'] . ": <b>" . $wiersz['author'] . "</b></p>";
            }

            echo '</div>';
            mysqli_close($baza);
        }
    }
}

?>