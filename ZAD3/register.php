<?php

include_once 'E:\xampp\htdocs\dz_2\ZAD2\htmllib.php';

session_start();

create_doctype();
begin_html();

begin_head();
echo create_element("title", true, ["contents" => "PRIJAVA"]);
end_head();

begin_body();

start_form("register_validation.php", "post");

echo create_element("label", true, ["contents" =>
        ["ime: ", create_input(["type" => "text", "name" => "ime"])]]) . "<br><br>";
echo create_element("label", true, ["contents" =>
        ["prezime: ", create_input(["type" => "text", "name" => "prezime"])]]) . "<br><br>";
echo create_element("label", true, ["contents" =>
        ["e-mail: ", create_input(["type" => "email", "name" => "email"])]]) . "<br><br>";
echo create_element("label", true, ["contents" =>
        ["password: ", create_input(["type" => "password", "name" => "password"])]]) . "<br><br>";

echo create_input(["type" => "submit", "value" => "Posalji"]) . "<br><br>";


end_form();

end_body();
end_html();