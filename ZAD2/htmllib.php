<?php

use JetBrains\PhpStorm\Pure;

/**
 * ispisuje sadržaj "<!doctype html>"
 */
function create_doctype(): void{
    echo "<!doctype html>";
}

/**
 * ispisuje otvarajući tag <html>
 */
function begin_html(): void{
    echo "<html>";
}

/**
 * ispisuje zatvarajući tag </html>
 */
function end_html(): void{
    echo "</html>";
}

/**
 * ispisuje otvarajući tag <head>
 */
function begin_head(): void{
    echo "<head>";
}

/**
 * ispisuje zatvarajuci tag </head>
 */
function end_head(): void{
    echo "</head>";
}

/**
 * iz asocijativnog polja izvlači sve atribute i vraća ih kao string
 *
 * @param array $params asocijativno polje parova atribut => vrijednost
 * @return string oblika atribut = vrijednost, može se sastojati od vise atributa
 */
#[Pure] function get_attributes(array $params = []): string{
    $allAttrs = "";
    foreach($params as $k => $v){
        if($k === "contents") continue;
        $allAttrs .= " " . strval($k) . "=" . "'" . strval($v) . "'";
    }
    return $allAttrs;
}

/**
 * ispisuje otvarajuci tag <body> i pridruzuje mu parove
 * atribut, vrijednost na temelju predanih parametara
 *
 * @param array $params asocijativno polje parova atribut => vrijednost
 */
function begin_body(array $params = []): void{
    $allAttrs = "<body" . get_attributes($params) . ">";

    echo $allAttrs;
}

/**
 * ispisuje zatvarajuci tag </body>
 */
function end_body(): void{
    echo "</body>";
}

/**
 * ispisuje otvarajuci tag <table> i pridruzuje mu parove
 * atribut, vrijednost na temelju predanih parametara
 *
 * @param array $params asocijativno polje parova atribut => vrijednost
 */
function create_table(array $params = []): void{
    $allAttrs = "<table" . get_attributes($params) . ">";

    echo $allAttrs;
}

/**
 * ispisuje zatvarajuci tag </table>
 */
function end_table(): void{
    echo "</table>";
}

/**
 * Generira html potreban za stvaranje jednog retka tablice.
 * U polju parametara koje prima su definirane i celije tablice i to
 * parametrom 'contents' (ne sadrzi vrijednosti celija nego HTML kod
 * koji definira svaku celiju)
 *
 * @param array $params asocijativno polje parova koje odreduje jedan
 * redak tablice
 * @return string niz znakova koji predstavlja HTML kod retka tablice
 */
#[Pure] function create_table_row(array $params = []): string{
    $allAttrs = "<tr" . get_attributes($params) . ">";

    $content = $params["contents"] ?? [];

    if(gettype($content) === "string"){
        $allAttrs .= $content;
    }else {
        foreach ($content as $c) {
            $allAttrs .= $c;
        }
    }
    $allAttrs .= "</tr>";

    return $allAttrs;
}

/**
 * Generira HTML kod celije. Sadrzaj celije odreden je
 * parametrom 'contents' koji se nalazi u asocijativnom polju
 *
 * @param array $params asocijativno polje parova koje odreduje jednu
 * celiju tablice
 * @return string niz znakova koji predstavlja HTML kod celije
 */
#[Pure] function create_table_cell(array $params = []): string{
    $allAttrs = "<td" . get_attributes($params) . ">";

    $content = $params["contents"] ?? [];
    $cell = "";

    if(gettype($content) === "string") {
        $cell .= $allAttrs . $content . "</td>";
    }else {
        foreach ($content as $c) {
            $cell .= $allAttrs . $c . "</td>";
        }
    }

    return $cell;
}

/**
 * Generira HTML kod proizvoljnog elementa
 *
 * @param string $name naziv elementa
 * @param bool $closed true ako ima zatvarajuci tag
 * @param array $params polje parametara koje odreduje element
 * @return string niz znakova jednak HTML kodu elementa
 */
#[Pure] function create_element(string $name, bool $closed = true, array $params = []): string{
    $element = "<" . $name . get_attributes($params);

    if ($closed) $element .= ">";

    $content = $params["contents"] ?? [];

    if(gettype($content) === "string") {
        $element .= $content;
    }else {
        foreach ($content as $c) $element .= $c;
    }
    $element = $closed ? $element . "</" . $name . ">" : $element . ">";   #pazi jel ide /

    return $element;
}

function start_form($action, $method, $enctype = null): void{
    $element = "<form " . "method=" . $method . " action=" . $action;
    $end = $enctype ? " enctype=" . $enctype . ">" : ">";
    $element .= $end;

    echo $element;      #jel vracam ili printam
}

function end_form(): void{
    echo "</form>";
}

#[Pure] function create_input($params): string{
    return "<input" . get_attributes($params) . ">";
}

#[Pure] function create_select($params): string{
    $element = "<select" . get_attributes($params) . ">";

    $content = $params["contents"] ?? [];

    if(gettype($content) === "string") {
        $element .= $content;
    }else {
        foreach ($content as $c) $element .= $c;
    }

    $element .= "</select>";

    return $element;
}

#[Pure] function create_button($params): string{
    $element = "<button" . get_attributes($params) . ">";

    $content = $params["contents"] ?? [];

    if(gettype($content) === "string") {
        $element .= $content;
    }else {
        foreach ($content as $c) $element .= $c;
    }

    $element .= "</button>";

    return $element;
}