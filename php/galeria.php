<?php

    function galeria() {
        $imgs = "../Img/";
        $zawartosc = scandir($imgs);
        array_shift($zawartosc);
        array_shift($zawartosc);

        
        foreach ($zawartosc as $img) {
            if ($img != "maps.png" && $img != "trash.png") {
                echo "<div style='text-align: center; font-weight: bold; margin: 2em;'>";
                echo "$img<br>";
                echo "<img src='../img/".$img."' alt='".$img."' style='width:300px; height:300px;'><br><br>";
                echo "</div>";
            }
        }
    }

?>