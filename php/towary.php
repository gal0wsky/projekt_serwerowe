<?php

function towary() {
    $towary = array(
        0 => array("Nazwa" => "Amol", "Img" => "../img/Towar1.png", "Cena" => 605.00),
        1 => array("Nazwa" => "APAP", "Img" => "../img/Towar2.png", "Cena" => 105.00),
        2 => array("Nazwa" => "Białko KFD", "Img" => "../img/Towar3.png", "Cena" => 300.00),
        3 => array("Nazwa" => "Olejek CBD", "Img" => "../img/Towar4.png", "Cena" => 17.95),
        4 => array("Nazwa" => "Gripex Hot Max", "Img" => "../img/Towar5.png", "Cena" => 212.99),
        5 => array("Nazwa" => "Ibuprom RR Max", "Img" => "../img/Towar6.png", "Cena" => 20.30),
        6 => array("Nazwa" => "Hyal-Drop Multi", "Img" => "../img/Towar7.png", "Cena" => 69.00),
        7 => array("Nazwa" => "Nasivin Soft", "Img" => "../img/Towar8.png", "Cena" => 420.00),
        8 => array("Nazwa" => "Paracetamol", "Img" => "../img/Towar9.png", "Cena" => 190.98),
        9 => array("Nazwa" => "Vix VapoRub", "Img" => "../img/Towar10.png", "Cena" => 55.55),
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

            echo "<li><span class='liHeader'>Nazwa: ".$towary[$i]["Nazwa"]."</span><br>Cena regularna: ".$towary[$i]["Cena"]." zł<br>Cena promocyjna: ".number_format($nowaCena, 2, ".", "").
            " zł<br><img src='".$towary[$i]["Img"]."' alt='towar'></li> <br><br>";
        }   
        else
            echo "<li><span class='liHeader'>Nazwa: ".$towary[$i]["Nazwa"]."</span><br>Cena regularna: ".$towary[$i]["Cena"]." zł<br><img src='".$towary[$i]["Img"]."' alt='towar'></li> <br><br>";
    }

    echo "</ul></div>";
    
}


?>