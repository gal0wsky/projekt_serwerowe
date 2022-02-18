<?php

function regexForm()
{
    if (isset($_POST["send"])) {
        $kwota = $_POST["kwota"];
        $pesel = $_POST["pesel"];
        $nip = $_POST["nip"];
        $ip = $_POST["ip"];
        $rejestracja = $_POST["rejestracja"];
        $email = $_POST["email"];
        $tel = $_POST["tel"];
        $wiek = $_POST["wiek"];
        $krew = $_POST["krew"];
        $data = $_POST["data"];
        $login = $_POST["login"];

        $regex = '/^\d+ (PLN|EUR|USD)$/';

        echo '<div style="margin: 2rem;">';

        if (preg_match($regex, $kwota))
            echo "Kwota pasuje";
        else
            echo "Kwota nie pasuje";

        echo "<br>";

        $regex = '/^\d{11}$/';

        if (preg_match($regex, $pesel))
            echo "PESEL pasuje";
        else
            echo "PESEL nie pasuje";

        echo "<br>";

        $regex = '/^\d{3}\-\d{3}\-\d{2}\-\d{2}$/';

        if (preg_match($regex, $nip))
            echo "NIP pasuje";
        else
            echo "NIP nie pasuje";

        echo "<br>";

        $regex = '/^\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}$/';

        if (preg_match($regex, $ip))
            echo "IP pasuje";
        else
            echo "IP nie pasuje";

        echo "<br>";

        $regex = '/^([A-Z0-9]\s[A-Z0-9]{5}|[A-Z]{2}\s[A-Z0-9]{5}|[A-Z]{3}\s[A-Z0-9]{4})$/';

        if (preg_match($regex, $rejestracja))
            echo "Rejestracja pasuje";
        else
            echo "Rejestracja nie pasuje";

        echo "<br>";

        $regex = '/^[\w\.]+@[a-z]{2,}\.(pl|com|eu)$/';

        if (preg_match($regex, $email))
            echo "Email pasuje";
        else
            echo "Email nie pasuje";

        echo "<br>";

        $regex = '/^([48]?\d{7}|\d{9})$/';

        if (preg_match($regex, $tel))
            echo "Nr telefonu pasuje";
        else
            echo "Nr telefonu nie pasuje";

        echo "<br>";

        $regex = '/^[1-9]+[0-9]{1,2}$/';

        if (preg_match($regex, $wiek))
            echo "Wiek pasuje";
        else
            echo "Wiek nie pasuje";

        // data

        echo "<br>";

        $regex = '/^\d{2}-\d{2}-\d{4}$/';

        if (preg_match($regex, $data))
            echo "Data pasuje";
        else
            echo "Data nie pasuje";

        echo "</div>";
    }
}
?>


<!-- <div class="form" style="margin: 2rem;">
    <form action="" method="POST">
        <p>Kwota:</p>
        <input type="text" name="kwota">
        <br>
        <p>PESEL:</p>
        <input type="text" name="pesel">
        <br>
        <p>NIP:</p>
        <input type="text" name="nip">
        <br>
        <p>IP:</p>
        <input type="text" name="ip">
        <br>
        <p>Tablica rejestracyjna:</p>
        <input type="text" name="rejestracja">
        <br>
        <p>E-mail:</p>
        <input type="text" name="email">
        <br>
        <p>Nr telefonu:</p>
        <input type="text" name="tel">
        <br>
        <p>Wiek (cyfra):</p>
        <input type="text" name="wiek">
        <br>
        <p>Grupa krwi:</p>
        <input type="text" name="krew">
        <br>
        <p>Data (dd-mm-rr):</p>
        <input type="text" name="data">
        <br>
        <p>Login:</p>
        <input type="text" name="login">
        <br>

        <input type="submit" name="send" value="Wyślij">
    </form>
</div> -->

<?php

?>