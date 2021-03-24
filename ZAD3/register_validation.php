<?php

include_once "DBDriver.php";
include_once 'E:\xampp\htdocs\dz_2\ZAD2\htmllib.php';

session_start();

if (isset($_SESSION["user_id"])) {
    echo "Lijep pozdrav " . $_SESSION["user"];
    die();
} else {

    $error = false;
    foreach($_POST as $key => $value) {

        if (!isset($_POST[$key]) || strlen(trim($_POST[$key])) == 0 ) {
            echo "Registracija nepotpuna. Nedostaje vrijednost $key. Molim pokusajte ponovno!</br>";

            $error = true;
        }
    }

    if (count($_POST) == 0) {
        $error = true;
    }

    if ($error == false) {
        $ime = $_POST["ime"];
        $prezime = $_POST["prezime"];
        $mail = $_POST["email"];
        $password = $_POST["password"];

        if (exists($mail, sha1($password))) {
            echo "Navedeni korisnik već postoji.</br>";

            $error = true;
        }
    }

    if ($error == false) {
        $newId = get_last_id("users.txt") + 1;
        set_new_user($newId, $ime, $prezime, $mail, sha1($password));
        $_SESSION["user"] = $ime . " " . $prezime;
        $_SESSION["user_id"] = $newId;

        echo "Uspjesno ste registrirani $ime $prezime!";

        start_form("index.php", "post");
        echo create_input(["type" => "submit", "value" => "Pocetna"]) . "<br><br>";
        end_form();

        die();
    }
}
