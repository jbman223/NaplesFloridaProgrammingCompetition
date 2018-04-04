<?php
require_once "../content/require.php";

if (!isUserLoggedIn()) {
    header("Location: ../account/login.php");
}

if (!isset($_POST['quiz_id'], $_POST['question_id'], $_POST['section_id'])) {
    header("location: index.php");
    die();
}

$state = $db->prepare("insert into quiz_answers (team_id, quiz_question_id, answer, status) values (?, ?, ?, ?)");
$state->execute(array($_SESSION['competition_site_id'], $_POST['question_id'], '', 0));
die();