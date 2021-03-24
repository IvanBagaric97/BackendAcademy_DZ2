<?php

include 'htmllib.php';
include 'helplib.php';

$pitanja = get_quizzes("quiz_questions.php");

$tocno = 0;
$ukupno = 0;
for($i = 1; $i <= count($pitanja); $i++){
    $odg = $_POST["pitanje" . strval($i)];
    if(count($odg) === 1) $odg = $odg[0];

    echo "Pitanje " . strval($i) . ": " . $pitanja[$i-1][1] . "<br>";

    if($pitanja[$i-1][0] === "1" | $pitanja[$i-1][0] === "3" | !is_array($odg)){
        if(strtoupper($odg) === strtoupper($pitanja[$i-1][3])) $tocno += 1;

        echo "Odgovoreno: " . htmlentities($odg) . "<br>" . "Tocno: " . $pitanja[$i-1][3] . "<br>" . "<br>";

    }else{
        $correct = str_replace(' ', '', $pitanja[$i-1][3]);
        $ans = implode(",", $odg);
        if($correct === $ans) $tocno += 1;

        echo "Odgovoreno: " . htmlentities($ans) . "<br>" . "Tocno: " . $correct . "<br>" . "<br>";
    }
    $ukupno += 1;
}

$postotak = ($tocno / $ukupno) * 100;

echo "Postotak:" . strval($postotak) . "%";