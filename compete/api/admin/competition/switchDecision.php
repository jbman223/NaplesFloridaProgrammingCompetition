<?php
require_once "../../../content/require.php";

if (!isUserLoggedIn()) {
    die();
}
if (!$user['admin']) {
    die();
}

if (isset($_POST['solved_problem_id'])) {
    $state = $db->prepare("update solved_problems set correct = not correct where id = ?");
    $state->execute(array($_POST['solved_problem_id']));
    die(json_encode(array("success" => "Decision switched.")));
} else {
    die(json_encode(array("error" => "No solved problem id.")));
}