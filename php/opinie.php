<?php

    function opinie() {
        echo '<div id="opinie">';
        echo "<h3>Piszą o nas:</h3>";
        echo '<ul id="opinieUl">';

        $file = fopen("../resources/opinie.txt", "r");

        while (!feof($file)) {
            echo "<li>".fgets($file)."</li><br>";
        }

        fclose($file);

        echo '</ul></div>';
    }

?>