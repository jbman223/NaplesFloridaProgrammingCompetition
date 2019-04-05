<?php
require_once "../../assets/require.php";

if (!isLoggedIn()) {
    die(json_encode(array("error" => "You must be logged in.")));
}

$state = $db->prepare("SELECT field_value FROM admin_current_competition");
$state->execute();
$fInfo = $state->fetchAll(PDO::FETCH_NUM);
$inComp =  filter_var($fInfo[1][0], FILTER_VALIDATE_BOOLEAN);
$id = intval($fInfo[3][0]);

$listing = array();

if (!$inComp) {
    array_push($listing, array("replies" => 0, "subject" => "There are no clarifications to view.", "title" => "N/A", "id" => -1));
    die(json_encode($listing));
}

$state = $db->prepare("SELECT * FROM threads WHERE competition_id = ? AND deleted = ?");
$state->execute(array($id, 0));
$threads = $state->fetchAll();

$state = $db->prepare("SELECT * FROM replies WHERE thread_id = ?");

foreach ($threads as $thread) {
    $state->execute(array($thread['id']));
    array_push($listing, array("replies" => count($state->fetchAll()), "subject" => $thread['title'], "title" => $thread['problem_id'], "id" => $thread['id']));
}

die(json_encode($listing));
