<?php

    $slowka = array(
        "kot" => "cat",
        "pies" => "dog",
        "krowa" => "cow",
        "świnka morska" => "guinea pig",
        "ptak" => "bird"
    );

    $slowko = array_rand($slowka);
    $wylosowaneSlowko = $slowka[$slowko];

    echo "<p id='slowko'>$slowko => $wylosowaneSlowko</p>";
?>