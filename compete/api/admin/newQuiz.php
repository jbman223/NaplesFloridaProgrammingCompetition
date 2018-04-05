<?php
require_once "../../content/require.php";

if (!isUserLoggedIn()) {
    die();
}
if (!$user['admin']) {
    die();
}

if (isset($_POST["quiz_name"])) {

    if (isset($_POST['id'])) {
        //initiate update procedure
        $state = $db->prepare("update quizzes set quiz_name = ? where id = ?");
        $state->execute(array($_POST["quiz_name"], $_POST['id']));
        die(json_encode(array("success" => "Quiz successfully updated.")));
    } else {
        //create brand new problem
        $state = $db->prepare("insert into quizzes (quiz_name) values (?)");
        $state->execute(array($_POST["quiz_name"]));
        die(json_encode(array("success" => "Quiz successfully added to the database.")));
    }
} else if (isset($_GET['id'])) {
    $state = $db->prepare("select * from quizzes where id = ?");
    $state->execute(array($_GET['id']));
    $problem = $state->fetchAll(PDO::FETCH_ASSOC);

    if (count($problem) == 1) {
        die(json_encode($problem[0]));
    } else {
        die(json_encode(array("error" => "No quiz found.")));
    }
} else {
    die(json_encode(array("error" => "All required fields were not received.")));
}