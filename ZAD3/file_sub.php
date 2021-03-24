<?php

include_once "DBDriver.php";
include_once 'E:\xampp\htdocs\dz_2\ZAD2\htmllib.php';

global $_homework_file;
$_homework_file = "homeworks.txt";

session_start();

if (isset($_FILES["datoteka"])) {
    $upload_dir = "uploads/";
    $uploadFile = $_FILES["datoteka"]["name"];


    $array = explode(".", $uploadFile);
    $fileExtension = end($array);

    $newName = $upload_dir . "file_" . time() . "." . $fileExtension;

    echo $newName . "</br>";

    if (move_uploaded_file($_FILES["datoteka"]["tmp_name"], $newName)) {

        set_new_homework(get_last_id("homeworks.txt") + 1, $_SESSION["user_id"],
            $uploadFile, "unesite broj bodova", "homeworks.txt");

        echo "Datoteka uspjesno prebacena!";
    } else {
        echo "Datoteka nije prebacena!";
    }
    start_form("log_out.php", "post");
    echo create_input(["type" => "submit", "value" => "Odjavi se"]) . "<br><br>";
    end_form();

    die();
}
