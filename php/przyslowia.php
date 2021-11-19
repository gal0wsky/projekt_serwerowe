<?php
    $przyslowia = array(
        "baba swoje, chłop swoje",
        "elektryka prąd nie tyka",
        "dla chcącego nic trudnego",
        "co za dużo, to niezdrowo",
        "co kraj, to obyczaj",
        "Amba Fatima, było i ni ma"
    );

    shuffle($przyslowia);

    echo "<p id='przyslowie'>$przyslowia[0]</p>"
?>