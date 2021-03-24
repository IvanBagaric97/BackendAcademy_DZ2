<?php

include 'htmllib.php';
include 'helplib.php';

$pitanja = get_quizzes("quiz_questions.php");

start_form("evaluate_quiz.php", "post");

$br_pitanja = 1;
if (isset($pitanja)) {
    foreach($pitanja as $p){

        if($p[0] === "1") $type = "radio";
        elseif ($p[0] === "2") $type = "checkbox";
        else $type = "text";

        $choice = array();
        $multiple_choice = $p[2];

        echo strval($br_pitanja) . ". " . $p[1] . "<br>";

        foreach($multiple_choice as $x){
            $choice[] = create_input(["type" => $type, "name" => "pitanje" . strval($br_pitanja) . "[]", "value" => $x]);
            $choice[] = $x;
            echo create_element("label", true, ["contents" => $choice]) . "<br>";
            $choice = array();
        }

        $br_pitanja += 1;
        echo "<br>";

    }
}

echo create_input(["type" => "submit", "value" => "Posalji"]);

end_form();