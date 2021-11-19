<?php

$wojewodztwa = array("małopolskie", "mazowieckie", "śląskie", "lubuskie");

if (isset($_POST["send"])) {
    echo "Potwierdzenie zgłoszenia<br>";

    $uzytkownik = $_POST["imie"];
    $zgloszenie = $_POST["zgloszenie"];
    $tryb = $_POST["tryb"];

    
    $powiadomienie = $uzytkownik . " napisał(a): " . $zgloszenie . " w trybie ";


    $data = date_create("2021-11-19");
    $dataDruku = $data;
    


    if ($tryb == "pilny") {
        $powiadomienie = $powiadomienie . '<span style="color:blue;">' . $tryb . '</span>';
        $dataDruku = date_modify($data, "+2 days");
    } else {
        $powiadomienie = $powiadomienie . '<span style="color:red;">' . $tryb . '</span>';
        $dataDruku = date_modify($data, "+7 days");
    }

    echo $powiadomienie;
    echo "<br><br>Termin wydruku <span style='font-weight: bold;'>".date_format($dataDruku, "d-m-Y")."</span>";
} else {
?>

    <form action="" method="POST">
        <p>Podaj imię:</p>
        <input type="text" name="imie" placeholder="Imię">

        <p>Podaj zgłoszenie:</p>
        <input type="textarea" name="zgloszenie" placeholder="Zgłoszenie">

        <p>Wskaż tryb:</p>
        <input type="radio" name="tryb" value="pilny">Pilny
        <br>
        <input type="radio" name="tryb" value="standard">Nie pilny
        <br>
        <input type="submit" name="send" value="Wyślij">
    </form>

    <br><br><br>

    <p>Województwa:</p>
    <select name="woj" id="woj">

        <?php
        foreach ($wojewodztwa as $wojewodztwo) {
            echo "<option value=" . $wojewodztwo . ">" . $wojewodztwo . "</option>";
        }
        ?>
    </select>

<?php
}

?>