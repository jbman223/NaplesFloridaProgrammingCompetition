<?php
require_once "/var/www/programmingcompetition.org/competitionSite/assets/require.php";

//first check if we are in a competition
$state = $db->prepare("SELECT * FROM admin_scheduled_competitions WHERE start_time < ? AND end_time > ?");
$state->execute(array(time(), time()));
$competitions = $state->fetchAll();
$state = $db->prepare("UPDATE admin_current_competition SET field_value = ? WHERE field_name =?");
if (count($competitions) == 1) {
    $state->execute(array($competitions[0]['competition_name'], "competition_name"));
    $state->execute(array("true", "in_competition"));
    $state->execute(array($competitions[0]['end_time'], "end_time"));
    $state->execute(array($competitions[0]['start_time'], "start_time"));
    $state->execute(array($competitions[0]['id'], "competition_id"));
    $state->execute(array(time(), "last_update"));
} else if (count($competitions) > 1) {
    echo "I don't know how to handle more than 1 competition!";
    die();
} else {
    $state->execute(array("", "competition_name"));
    $state->execute(array("false", "in_competition"));
    $state->execute(array("", "end_time"));
    $state->execute(array("", "start_time"));
    $state->execute(array(time(), "last_update"));
    $state->execute(array("", "competition_id"));
    echo "No competitions ";
    die();
}
