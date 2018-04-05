<?php
require_once "../content/require.php";

if (!isUserLoggedIn()) {
    header("Location: ../account/login.php");
}

if (!isset($_POST['quiz_id'], $_POST['question_id'], $_POST['section_id'], $_POST['answer'])) {
    header("location: index.php");
    die();
}

$answers = array("A", "B", "C", "D", "E");
if (!in_array($_POST['answer'], $answers)) {
    header("location: take.php?id=".$_POST['quiz_id']."&section_id=".$_POST['section_id']);
    die();
}

$state = $db->prepare("select * from quiz_answers where team_id = ? and quiz_question_id = ? and (status = -1 or status = 1)");
$state->execute(array($_SESSION['competition_site_id'], $_POST['question_id']));
$answers = $state->fetchAll(PDO::FETCH_ASSOC);
if (count($answers) != 0) {
    header("location: take.php?id=".$_POST['quiz_id']."&section_id=".$_POST['section_id']);
    die();
}

$state = $db->prepare("select * from quiz_questions where id = ?");
$state->execute(array($_POST['question_id']));
$question = $state->fetchAll(PDO::FETCH_ASSOC);

if (count($question) == 1) {
    $question = $question[0];
} else {
    header("location: take.php?id=".$_POST['quiz_id']."&section_id=".$_POST['section_id']);
    die();
}

$status = 0;

if ($question['answer'] == $_POST['answer']) $status = 1;
else $status = -1;

$state = $db->prepare("delete from quiz_answers where team_id = ? and quiz_question_id = ? and status = 0");
$state->execute(array($_SESSION['competition_site_id'], $_POST['question_id']));

$state = $db->prepare("insert into quiz_answers (team_id, quiz_question_id, answer, status) values (?, ?, ?, ?)");
$state->execute(array($_SESSION['competition_site_id'], $_POST['question_id'], $_POST['answer'], $status));
header("location: take.php?id=".$_POST['quiz_id']."&section_id=".$_POST['section_id']);
die();