<?php
require_once "../../content/require.php";

if (!isUserLoggedIn()) {
    die(json_encode(array("error" => "Please refresh the page.")));
}

if (isset($_POST['message'], $_POST['thread_id'])) {
    $state = $db->prepare("insert into replies (thread_id, message, poster_id, post_time) values (?, ?, ?, ?)");
    $state->execute(array($_POST['thread_id'], $_POST['message'], $user['id'], time()));
    die(json_encode(array("success" => "Thread posted.")));
} else {
    die(json_encode(array("error" => "Proper inputs were not received.")));
}