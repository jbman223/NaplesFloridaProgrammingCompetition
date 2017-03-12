<?php
require_once "../../../content/require.php";

if (!isUserLoggedIn()) {
    die();
}
if (!$user['admin']) {
    die();
}

if (isset($_POST['section_id'], $_POST['problem_id'])) {
    $state = $db->prepare("insert into competition_section_problems (section_id, problem_id) values (?, ?)");
    $state->execute(array($_POST['section_id'], $_POST['problem_id']));
    die(json_encode(array("success" => "Problem created.")));
} else {
    die(json_encode(array("error" => "Problem not created.")));
}