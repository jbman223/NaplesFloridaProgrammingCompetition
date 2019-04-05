<?php
require_once "../content/require.php";

$conn = $db->prepare("INSERT INTO mcq (id, answers, correct, score) VALUES (?, ?, ?, ?)");



$id = htmlspecialchars($_POST["id"]);

if (!($id)) {

    $id = "John Doe";

}



$a = htmlspecialchars($_POST["ans"]);

$answerArray = json_decode(html_entity_decode($a));

$answers = strtolower(html_entity_decode($a));



//change these accordingly

$correctArray = array(
    'c','c','c','a','c',
    'a','c','d','c','b',
    'a','a','c','a','d',
    'a','a','b','c','c',
    'b','e','b','a','d',
    'e','d','c','c','c',
    'b','d','c','e','c',
    'c','d','c','c','c',
    'd','c');


$correct = json_encode($correctArray);



//echo '<H1>' . count($answerArray) . '</H1>';



$score = 0;

for ($i = 0; $i < count($correctArray); $i++) {

    if (strtolower($correctArray[$i]) == strtolower($answerArray[$i])) {

        echo "<h2>" . ($i+1) . ": correct</h2></br>";

        $score += 4;

    } else if ($answerArray[$i] == "") {}

    else {

        $score -= 1;

        echo "<h2>" . ($i+1) . ": incorrect</h2></br>";

    }

}



$conn->execute(array($id, $answers, $correct, $score));

//echo '<meta http-equiv="refresh" content="0;url=http://programmingcompetition.org/"/>';

die("<h1>Thank you for taking the test. Your score is: " . $score . "</h1>");

//die("Thank you for finishing The 2017 NFPC Multiple Choice Test, you may close this window. If it hasn't been closed already.");