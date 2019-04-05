<?php
require_once "../../assets/require.php";

if (!isLoggedIn()) {
    die(json_encode(array("error" => "You must be logged in.")));
}

if (!isset($_POST['id'])) {
    die(json_encode(array("error" => "You cannot do that.")));
}

$message = array();

$state = $db->prepare("SELECT * FROM threads WHERE id = ?");
$state->execute(array($_POST['id']));
$thread = $state->fetchAll()[0];

$message['is_owner'] = $thread['team_id'] == $_SESSION['team_id'];
$message['owner_id'] = $thread['team_id'];
$message['topic'] = htmlspecialchars_decode($thread['message']);
$message['replies'] = array();

$state = $db->prepare("SELECT * FROM replies WHERE thread_id = ?");
$state->execute(array($thread['id']));
$replies = $state->fetchAll();

$state = $db->prepare("SELECT * FROM teams WHERE id = ?");

for ($i = 0; $i < count($replies); $i++) {
    $message['replies'][$i] = array();
    $message['replies'][$i]['message'] = $replies[$i]['message'];
    $state->execute(array($replies[$i]['poster_id']));
    $team = $state->fetchAll();
    $message['replies'][$i]['posted_by'] = $team[0]['team_name'];
}

die(json_encode(array("message" => $message)));