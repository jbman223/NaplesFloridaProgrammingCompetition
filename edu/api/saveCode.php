<?php
require_once "require.php";

if (isset($_SESSION['currentProblem'], $_POST['code']) && isUserLoggedIn()) {
    $user = user();
    $state = $db->prepare("insert into edu_problem_state (edu_problem_id, user_id, code, `time`) values (?, ?, ?, ?)");
    $state->execute(array($_SESSION['currentProblem'], $user['id'], $_POST['code'], time()));
    echo "saved";
} else {
    echo "not saved";
}