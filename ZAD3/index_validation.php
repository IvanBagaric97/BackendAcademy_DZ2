<?php

include_once "DBDriver.php";
include_once 'E:\xampp\htdocs\dz_2\ZAD2\htmllib.php';

global $_homework_file;
$_homework_file = "homeworks.txt";

session_start();

if (isset($_SESSION["user"])) {
    create_doctype();
    begin_html();
    begin_head();
    echo create_element("title", true, ["contents" => "DOMACA ZADACA"]);
    end_head();

    begin_body();
    echo "Lijep pozdrav " . $_SESSION["user"] . "<br>";

    if(check_if_submitted($_SESSION["user_id"], $_homework_file)){
        if(is_numeric($bodovi = get_points($_SESSION["user_id"], $_homework_file))){
            echo "Broj bodova ostvarenih na zadaci je $bodovi";
        }else{
            echo "Zadaca nije ocijenjena";
            echo var_dump($bodovi);
        }
        start_form("log_out.php", "post");
        echo create_input(["type" => "submit", "value" => "Odjavi se"]) . "<br><br>";
        end_form();
    }else{
        start_form("file_sub.php", "post", "multipart/form-data");
        echo create_element("label", true, ["contents" => ["Datoteka: ",
                                create_input(["type" => "file", "name" => "datoteka"])]]);

        echo create_input(["type" => "submit", "value" => "Posalji"]) . "<br><br>";

        end_form();

        start_form("log_out.php", "post");
        echo create_input(["type" => "submit", "value" => "Odjavi se"]) . "<br><br>";
        end_form();
    }
    end_body();
    end_html();
    die();
} else {

    $error = false;
    foreach($_POST as $key => $value) {

        if (!isset($_POST[$key]) || strlen(trim($_POST[$key])) == 0 ) {
            echo "Prijava nepotpuna. Nedostaje vrijednost $key. Molim pokusajte ponovno!</br>";

            $error = true;
        }
    }

    if (count($_POST) == 0) {
        $error = true;
    }

    if ($error == false) {
        $email = $_POST["email"];
        $password = $_POST["password"];

        $user = get_user_by_mail_and_pass($email, sha1($password));
        if ($user) {
            echo "Uspjesno ste prijavljeni " . htmlentities($user["ime"]) . " " . htmlentities($user["prezime"]);
            $_SESSION["user"] = $user["ime"] . " " . $user["prezime"];
            $_SESSION["user_id"] = $user["user_id"];
            header("Location: index_validation.php");
            die();
        } else {
            echo "Neispravno korisnicko ime ili lozinka.</br>";
            $error = true;
        }
    }
}
