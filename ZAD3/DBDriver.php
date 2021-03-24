<?php

//GLOBALNE POSTAVKE ZA BAZU
global $_user_file;
$_user_file = 'users.txt';

/*
 * Unesi novog korisnika u bazu
 */
function set_new_user($id, $ime, $prezime, $mail, $pass) {
    global $_user_file;

    $user = array($id, $ime, $prezime, $mail, $pass);
    $prepared = implode(";", $user);
    $current = file_get_contents($_user_file);
    $current .= trim($prepared) .  "\n";
    file_put_contents($_user_file, $current, LOCK_EX);
}

/*
 * Dohvati korisnika po emailu i lozinci.
 */
function get_user_by_mail_and_pass($mail, $pass): ?array{
    global $_user_file;
    $file = file_get_contents($_user_file);
    $lines = explode("\n", $file);
    $user = array();
    foreach ($lines as $line) {
        $split = explode(";", trim($line));
        //provjera ima li učitana linija dovoljno argumenata
        if (count($split) < 5) return null;
        if ($split[3] !== $mail || $split[4] !== $pass) continue;
        $user["user_id"] = $split[0];
        $user["ime"] = $split[1];
        $user["prezime"] = $split[2];
        break;
    }
    return $user;
}

/*
 * Dohvati korisnika po id.
 */
function get_user_by_id($id): array{
    global $_user_file;
    $file = file_get_contents($_user_file);
    $lines = explode("\n", trim($file));
    $user = array();
    foreach ($lines as $line) {
        $split = explode(";", $line);
        if ($split[1] != $id) continue;
        $user["name"] = $split[1];
        $user["pass"] = $split[2];
        break;
    }
    return $user;
}

function get_last_id($from): int{
    $file = file_get_contents($from);
    $lines = explode("\n", trim($file));
    $split = explode(";", end($lines));
    return intval($split[0]);
}

/*
 * Postoji li korisnik u datoteci.
 */
function exists($email, $pass): bool{
    $user = get_user_by_mail_and_pass($email, $pass);
    return isset($user["pass"]);
}

function check_if_submitted($userId, $fileName): bool{
    $file = file_get_contents($fileName);
    $lines = explode("\n", trim($file));
    foreach ($lines as $line) {
        if(ctype_space($line) | $line === "") continue;
        #echo var_dump($line);
        $split = explode(";", $line);
        if ($split[1] === $userId) return true;
    }
    return false;
}

function get_points($userId, $fileName){
    $file = file_get_contents($fileName);
    $lines = explode("\n", trim($file));
    foreach ($lines as $line) {
        $split = explode(";", $line);
        if ($split[1] === $userId) return $split[3];
    }
    return false;
}

function set_new_homework($homework_id, $user_id, $ime_datoteke, $broj_bodova, $file) {

    $homework = array($homework_id, $user_id, $ime_datoteke, $broj_bodova);
    $prepared = implode(";", $homework);
    $current = file_get_contents($file);
    $current .= trim($prepared) .  "\n";
    file_put_contents($file, $current, LOCK_EX);
}