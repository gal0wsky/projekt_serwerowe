<?php

?>

<!DOCTYPE html>
<html lang="pl-PL">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projekt serwerowe</title>

    <?php
    include("towary.php");
    include("kontakt.php");
    include("opinie.php");
    include("galeria.php");
    include("zgloszenie.php");
    ?>
    <link rel="stylesheet" href="../css/index.css?v=<?php echo time(); ?>">
</head>

<body>
    <header>
        <h1 class="centerVertically">YESmed Twoja apteka online!</h1>
    </header>

    <nav>
        <h2>Menu:</h2>
        <ul>
            <li><a href="index.php">Strona główna</a></li>
            <li><a href="index.php?id=kontakt">Kontakt</a></li>
            <li><a href="index.php?id=opinie">Opinie</a></li>
            <li><a href="index.php?id=galeria">Galeria</a></li>
            <li><a href="index.php?id=zgloszenie">Zgłoszenie</a></li>
        </ul>
    </nav>

    <main>

        <?php

        $href = @$_GET["id"];

        if ($href == "kontakt")
            kontakt();
        else if ($href == "opinie")
            opinie();
        else if ($href == "galeria")
            galeria();
        else if ($href == "zgloszenie")
            zgloszenie();
        else
            towary();

        ?>
    </main>

    <footer>
        <!-- <p class="centerVertically" >Zagraj w lotto przyjacielu! Spróbuj szczęścia i wylosuj 6 liczb!</p> -->
        <p class="centerVertically">Copyright &copy; Maciej Gawłowski 2021</p>
        <!-- <div id="phpContent">
            <?php include("lotto.php"); ?>
            <br>
            <?php include("przyslowia.php") ?>
            <br>
            <?php include("slowniczek.php") ?>
            <br>
        </div> -->
    </footer>
</body>

</html>