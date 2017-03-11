<?php
require_once "../../content/require.php";

if (!isUserLoggedIn()) {
    die(json_encode(array("error" => "Please refresh the page.")));
}

if (isset($_POST['type'], $_POST['problem_id'], $_POST['section_id'], $_POST['message'], $_POST['title'])) {
    if (in_array($_POST['type'], array("Question Error", "Website Error/Question", "Computer Error/Question"))) {
        $subject = $_POST['title'];
        if (filter_var($_POST['problem_id'], FILTER_VALIDATE_INT) && $_POST['type'] == "Question Error") {
            $state = $db->prepare("select * from problem_data where id = ?");
            $state->execute(array($_POST['problem_id']));
            $problems = $state->fetchAll(PDO::FETCH_ASSOC);
            if (count($problems) > 0) {
                $subject = $problems[0]['problem_title'];
            }
        }

        $state = $db->prepare("insert into threads (problem_id, team_id, section_id, title, subject, message, post_time) values (?, ?, ?, ?, ?, ?, ?)");
        $state->execute(array($_POST['problem_id'], $user['id'], $_POST['section_id'], $_POST['type'], htmlspecialchars($subject), htmlspecialchars($_POST['message']), time()));
        die(json_encode(array("success" => "Thread posted.")));
    } else {
        die(json_encode(array("error" => "Improper type.")));
    }
} else {
    die(json_encode(array("error" => "Proper inputs were not received.")));
}