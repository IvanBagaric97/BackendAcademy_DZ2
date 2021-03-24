<?php

include_once 'E:\xampp\htdocs\dz_2\ZAD2\htmllib.php';

session_start();


if (isset($_SESSION["user"])) {
    header("Location: index_validation.php");
    die();
}


create_doctype();
begin_html();

begin_head();
echo create_element("title", true, ["contents" => "PRIJAVA"]);
end_head();

begin_body();

start_form("index_validation.php", "post");

echo create_element("label", true, ["contents" =>
    ["e-mail: ", create_input(["type" => "email", "name" => "email"])]]) . "<br><br>";
echo create_element("label", true, ["contents" =>
    ["password: ", create_input(["type" => "password", "name" => "password"])]]) . "<br><br>";

echo create_input(["type" => "submit", "value" => "Posalji"]) . "<br><br>";

echo "Need an acount? Create it " .
    create_element("a", true, ["href" => "register.php", "title" => "Register", "contents" => "here"]);


end_form();

end_body();
end_html();