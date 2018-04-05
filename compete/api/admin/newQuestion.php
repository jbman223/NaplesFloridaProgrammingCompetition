<?php
require_once "../../content/require.php";

if (!isUserLoggedIn()) {
    die();
}
if (!$user['admin']) {
    die();
}

if (isset($_POST["author"], $_POST["picture"], $_POST["answer"], $_POST['quiz_id'])) {

    if (isset($_POST['question_id'])) {
        //initiate update procedure
        $state = $db->prepare("update quiz_questions set author = ?, picture = ?, answer = ? where id = ?");
        $state->execute(array($_POST["author"], $_POST['picture'], $_POST['answer'], $_POST['id']));
        die(json_encode(array("success" => "Question successfully updated.")));
    } else {
        //create brand new problem
        $state = $db->prepare("insert into quiz_questions (author, picture, answer, quiz_id) values (?, ?, ?, ?)");
        $state->execute(array($_POST["author"], $_POST['picture'], $_POST['answer'], $_POST['quiz_id']));
        die(json_encode(array("success" => "Question successfully added to the database.")));
    }
} else if (isset($_GET['question_id'])) {
    $state = $db->prepare("select * from quiz_questions where id = ?");
    $state->execute(array($_GET['question_id']));
    $problem = $state->fetchAll(PDO::FETCH_ASSOC);

    if (count($problem) == 1) {
        die(json_encode($problem[0]));
    } else {
        die(json_encode(array("error" => "No question found.")));
    }
} else {
    die(json_encode(array("error" => "All required fields were not received.")));
}