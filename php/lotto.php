<?php
    $liczby = array();
    $liczba = null;
    $wylosowana = null;
    $licznik = 0;

    echo "<h3>Lotto</h3>";

     while ($licznik != 6) {
        $liczba = rand(1, 50);

        $wylosowana = array_search($liczba, $liczby);

        if ($wylosowana == 0) {
            array_push($liczby, $liczba);
            $licznik++;
        }
    }

    sort($liczby);

    echo '<table id="lotto">';

    foreach ($liczby as $liczba) {
        echo "<tr><td>$liczba</td></tr>";
    }

    echo "</table>";

?>