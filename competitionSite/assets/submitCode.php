<?php
require_once "require.php";
require_once "sphereEngine.php";
ignore_user_abort(true);

if (!isLoggedIn()) {
    die(json_encode(array("error" => "You must be logged in.")));
}

if (!isset($_POST['problem_id'], $_POST['language'], $_POST['code'])) {
    die(json_encode(array("error" => "All fields must be entered.")));
}

$state = $db->prepare("SELECT * FROM problems WHERE id = ?");
$state->execute(array($_POST['problem_id']));
$problems = $state->fetchAll();

if (count($problems) != 1) {
    die(json_encode(array("error" => "Problem Not Found!")));
}

$problem = $problems[0];



$submit = submitCode(str_replace("public class", "class", $_POST['code']), $_POST['language'], file_get_contents($problem['problem_input_file']));
$link = $submit['link'];

$state = $db->prepare("INSERT INTO submissions (problem_id, team_id, competition_id, link, `time`) VALUES (?, ?, ?, ?, ?)");
$state->execute(array($problem['id'], $_SESSION['team_id'], $problem['competition_id'], $link, time()));

if ($submit['error'] != 'OK') {
    die(json_encode(array("error" => $submit['error'])));
}

$status = submissionStatus($link);
while ($status['status'] != "0") {
    sleep(1);
    $status = submissionStatus($link);
}

if ($status['result'] != "15") {
    die(json_encode(array("error" => $submissionStatus[$status['result']])));
}

$result = submissionResult($link);

$outputMD5 = md5(preg_replace('/\s+/', '', $result['output']));

if ($outputMD5 === $problem['output_hash']) {
    $statement = $db->prepare("INSERT INTO solved_problems (team_id, competition_id, problem_id, `time`, link) VALUES (?, ?, ?, ?, ?)");
    $statement->execute(array($_SESSION['team_id'], $problem['competition_id'], $problem['id'], time(), $link));
    die(json_encode(array("success" => "You have successfully solved the problem!")));
} else {
    die(json_encode(array("error" => "Your program output did not match the required output.")));
}