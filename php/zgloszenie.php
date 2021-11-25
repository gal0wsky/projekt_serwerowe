<?php

function zgloszenie()
{

    $wojewodztwa = array("małopolskie", "mazowieckie", "śląskie", "lubuskie");

    if (isset($_POST["send"])) {
        echo "<div class='zgloszenieInfo' style='font-size: 2em; font-weight: bold;'>Potwierdzenie zgłoszenia</div><br>";

        $uzytkownik = $_POST["imie"];
        $zgloszenie = $_POST["zgloszenie"];
        $tryb = $_POST["tryb"];


        $powiadomienie = $uzytkownik . " napisał(a): " . $zgloszenie . "<br> -- w trybie ";


        $data = date_create("2021-11-19");
        $dataDruku = $data;



        if ($tryb == "pilny") {
            $powiadomienie = $powiadomienie . '<span style="color:blue;">' . $tryb . '</span>';
            $dataDruku = date_modify($data, "+2 days");
        } else {
            $powiadomienie = $powiadomienie . '<span style="color:red;">' . $tryb . '</span>';
            $dataDruku = date_modify($data, "+7 days");
        }

        echo '<div class="zgloszenieInfo">'.$powiadomienie.'</div>';
        echo "<br><br><div class='zgloszenieInfo'>Termin wydruku <span style='font-weight: bold;'>" . date_format($dataDruku, "d-m-Y") . "</span></div>";
    } else {
?>

        <div class="zgloszenieForm">
            <form action="" method="POST">
                <p>Podaj imię:</p>
                <input type="text" name="imie">

                <div id="zgloszenie">
                    <p>Podaj zgłoszenie:</p>
                    <textarea type="textarea" name="zgloszenie" cols="43" rows="12" id="zgloszenieTresc">
                        
                    </textarea>
                </div>

                <div id="tryby">
                    <p>Wskaż tryb:</p>
                    <div class="tryb">
                        <input type="radio" name="tryb" value="pilny">
                        <p>Pilny</p>
                    </div>
                    <br>
                    <div class="tryb">
                        <input type="radio" name="tryb" value="standard">
                        <p>Nie pilny</p>
                    </div>
                </div>
                <br>
                <input type="submit" name="send" value="Wyślij">
            </form>
        </div>

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
}
?>