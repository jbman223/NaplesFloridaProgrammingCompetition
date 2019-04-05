<?php
require_once "require.php";

function humanRemaining($timeRemaining) {
    if ($timeRemaining > 60) {
        return intval($timeRemaining/60). " minutes";
    } else {
        return $timeRemaining. " seconds";
    }
}

//get info
$state = $db->prepare("SELECT field_value FROM admin_current_competition");
$state->execute();
$fInfo = $state->fetchAll(PDO::FETCH_NUM);

$competition = array (
    "in_competition" => filter_var($fInfo[1][0], FILTER_VALIDATE_BOOLEAN),
    "server_time" => time(),
    "server_time_human" => date("g:i:s M jS, Y", time()),
    "competition_name" => $fInfo[0][0],
    "competition_end_time" => intval($fInfo[2][0]),
    "competition_end_time_human" => date("g:i A, F jS, Y", intval($fInfo[2][0])),
    "competition_start_time" => intval($fInfo[4][0]),
    "competition_start_time_human" => date("g:i A, F jS, Y", intval($fInfo[4][0])),
    "time_remaining" => intval($fInfo[2][0])-time(),
    "time_remaining_human" => humanRemaining(intval($fInfo[2][0])-time()),
    "competition_id" => intval($fInfo[3][0]),
    "last_update" => humanRemaining(time()-intval($fInfo[5][0])),
    "focus_mode" => filter_var($fInfo[6][0], FILTER_VALIDATE_BOOLEAN)
);

$state = $db->prepare("SELECT * FROM problems WHERE competition_id = ?");
$state->execute(array($competition['competition_id']));
$competition['problem_count'] = count($state->fetchAll());

die(json_encode($competition));