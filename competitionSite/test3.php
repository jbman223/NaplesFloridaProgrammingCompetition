<?php
require_once "assets/require.php";
require_once "assets/sphereEngine.php";

$state = $db->prepare("SELECT * FROM submissions WHERE problem_id = ? AND competition_id = ?");
$state->execute(array(94, 39));
$answers = $state->fetchAll();

foreach ($answers as $answer)
{
    $output =  md5(preg_replace('/\s+/', '', submissionResult($answer['link'])['output']));
    $realOutput = md5(preg_replace('/\s+/', '', file_get_contents("output.txt")));
    if ($realOutput == $output) {
        echo $answer['team_id']." ".$answer['time']."<br>";
    }
}