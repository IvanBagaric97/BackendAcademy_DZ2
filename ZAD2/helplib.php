<?php

function get_quizzes($file): array{
    $handle = fopen("quiz_questions.txt", "r");
    $pitanja = array();
    if ($handle) {
        while (($line = fgets($handle)) !== false) {
            $pitanje = array();
            if($line[0] === "#" | ctype_space($line)) continue;

            $l = explode(":", $line);
            $pitanje[] = trim(substr($l[0], -2)[0]);
            $pitanje[] = trim(explode("{", $l[0])[0]);

            $x = explode("=", $l[1]);
            $polje_ponudenih = array();
            foreach (explode(",", $x[0]) as $a){
                $polje_ponudenih[] = trim($a);
            }
            $pitanje[] = $polje_ponudenih;
            $pitanje[] = trim($x[1]);

            $pitanja[] = $pitanje;
        }
        fclose($handle);
    } else {
        echo "Error, file could not be opened";
    }
    return $pitanja;
}