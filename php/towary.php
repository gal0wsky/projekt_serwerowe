<?php

function towary() {
    $towary = array(
        0 => array("Nazwa" => "Towar 1", "Img" => "../img/Towar1.jpg", "Cena" => 605.00),
        1 => array("Nazwa" => "Towar 2", "Img" => "../img/Towar2.jpg", "Cena" => 105.00),
        2 => array("Nazwa" => "Towar 3", "Img" => "../img/Towar3.jpg", "Cena" => 300.00),
        3 => array("Nazwa" => "Towar 4", "Img" => "../img/Towar4.jpg", "Cena" => 17.95),
        4 => array("Nazwa" => "Towar 5", "Img" => "../img/Towar5.jpg", "Cena" => 212.99),
        5 => array("Nazwa" => "Towar 6", "Img" => "../img/Towar6.jpg", "Cena" => 20.30),
        6 => array("Nazwa" => "Towar 7", "Img" => "../img/Towar7.jpg", "Cena" => 69.00),
        7 => array("Nazwa" => "Towar 8", "Img" => "../img/Towar8.jpg", "Cena" => 420.00),
        8 => array("Nazwa" => "Towar 9", "Img" => "../img/Towar9.jpg", "Cena" => 190.98),
        9 => array("Nazwa" => "Towar 10", "Img" => "../img/Towar10.jpg", "Cena" => 55.55),
    );

    $promocje = array(
        "upust5%" => 0.95,
        "upust10%" => 0.9,
        "upust20zl" => 20
    );

    // foreach ($towary as $towar) {
    //     foreach ($towar as $k => $w) 
    //         echo "$k - $w<br>";

    //     echo "<br>";
    // }

    // $randPos = Array(rand(0,6), rand(7,9));

    echo '<div id="towary"><ul>';
                


    shuffle($towary);
    
        $nowaCena = 0;

    for ($i=0; $i<2; $i++) {
        if ($towary[$i]["Cena"] > 200) {
            $rng = ($i / 10) * 1.5;
            if ($towary[$rng] < 0.35)
                $nowaCena = $towary[$i]["Cena"] - $promocje["upust20zl"];
            else if ($towary[$rng] < 5)
                $nowaCena = $towary[$i]["Cena"] * $promocje["upust5%"];
            else
                $nowaCena = $towary[$i]["Cena"] * $promocje["upust10%"];

            echo "<li>Nazwa: ".$towary[$i]["Nazwa"]."<br>Cena regularna: ".$towary[$i]["Cena"]."<br>Cena promocyjna: ".$nowaCena.
            "<br><img src='".$towary[$i]["Img"]."' alt='towar'></li> <br><br>";
        }   
        else
            echo "<li>Nazwa: ".$towary[$i]["Nazwa"]."<br>Cena regularna: ".$towary[$i]["Cena"]."<br><img src='".$towary[$i]["Img"]."' alt='towar'></li> <br><br>";
    }

    echo "</ul></div>";
    
}


?>