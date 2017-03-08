<?php
require_once "../require.php";

if (!isset($_POST['videoName'], $_POST['name'], $_POST['id'], $_POST['email'])) {
    die(json_encode(array("error" => "All inputs not received.")));
}

if (strlen($_POST['id']) != 11) {
    die(json_encode(array("error" => "Incorrect video ID")));
}

$state = $db->prepare("select video_id from videos where video_id = ?");
$state->execute(array($_POST['id']));
$others = $state->fetchAll(PDO::FETCH_ASSOC);
if (count($others) > 0) {
    die(json_encode(array("error" => "That video has already been uploaded!")));
}

$state = $db->prepare("insert into videos (video_id, `name`, video_name, email_address) values (?, ?, ?, ?)");
$state->execute(array($_POST['id'], $_POST['name'], $_POST['videoName'], $_POST['email']));