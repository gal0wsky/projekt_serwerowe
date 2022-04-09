<?php

function getDatabaseConnectionProfile($profileName) {
    $json = file_get_contents("../resources/login.json");
    $json = json_decode($json, true);
    
    $profile = $json[$profileName];

    return $profile;
}

?>