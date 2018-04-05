<?php
require_once "../../../content/require.php";

if (!isUserLoggedIn()) {
    die();
}
if (!$user['admin']) {
    die();
}

if (isset($_POST['section_id'], $_POST['quiz_id'])) {
    $state = $db->prepare("insert into section_quizzes (section_id, quiz_id) values (?, ?)");
    $state->execute(array($_POST['section_id'], $_POST['quiz_id']));
    die(json_encode(array("success" => "Quiz added.")));
} else {
    die(json_encode(array("error" => "Quiz not added.")));
}