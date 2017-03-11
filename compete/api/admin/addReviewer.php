<?php
require_once "../../content/require.php";
require_once "../../../api/mailAPI.php";

if (!isUserLoggedIn()) {
    die();
}
if (!$user['admin']) {
    die();
}

if (isset($_POST['email'], $_POST['type'], $_POST['problem_id']) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    $password = generatePassword();
    $state = $db->prepare("insert into reviewers (email_address, review_type, problem_id, password) values (?, ?, ?, ?)");
    $state->execute(array($_POST['email'], ($_POST['type'] == 'description')?0:1, $_POST['problem_id'], md5($password)));
    sendReviewEamil($_POST['email'], $password, $_POST['problem_id']);
    die(json_encode(array("success" => "User added.")));
} else {
    die(json_encode(array("error" => "Improper request.")));
}