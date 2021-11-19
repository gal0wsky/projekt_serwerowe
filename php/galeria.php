<?php

    function galeria() {
        $imgs = "../Img/";
        $zawartosc = scandir($imgs);
        array_shift($zawartosc);
        array_shift($zawartosc);
        foreach ($zawartosc as $img) {
            echo "$img<br>";
            echo "<img src='../Img/".$img."' alt='".$img."' style='width:300px; height:300px;'><br><br>";
        }
    }

?>