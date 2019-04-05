<?php
require_once "../../assets/require.php";

if (!isLoggedIn()) {
    die(json_encode(array("error" => "You must be logged in.")));
}

$state = $db->prepare("SELECT field_value FROM admin_current_competition");
$state->execute();
$fInfo = $state->fetchAll(PDO::FETCH_NUM);
$inComp =  filter_var($fInfo[1][0], FILTER_VALIDATE_BOOLEAN);
$id = intval($fInfo[3][0]);

if (isset($_POST['type'])) {
    if ($_POST['type'] == "create") {
        if (!$inComp) {
            die(json_encode(array("error" => "You cannot start a clarification request if we are not in a competition!")));
        }

        if (isset($_POST['message'], $_POST['subject'], $_POST['problem'], $_POST['title'])) {
            if (strlen($_POST['title']) > 50) {
                die(json_encode(array("error" => "Your title is too long.")));
            }

            if (strlen($_POST['title']) < 10) {
                die(json_encode(array("error" => "Your title is too short. You need ".(10-strlen($_POST['title']))." more characters.")));
            }
            $state = $db->prepare("INSERT INTO threads (problem_id, competition_id, team_id, message, post_time, title) VALUES (?, ?, ?, ?, ?, ?)");
            $state->execute(array(htmlspecialchars($_POST['problem']), $id, $_SESSION['team_id'], htmlspecialchars($_POST['message']), time(), htmlspecialchars($_POST['title'])));
            die(json_encode(array("success" => "Your clarification has been posted.", "id" => $db->lastInsertId())));
        } else {
            die(json_encode(array("error" => "Please fill out all fields.")));
        }
    } else if ($_POST['type'] == "create_reply") {
        if (!$inComp) {
            die(json_encode(array("error" => "You cannot reply to this clarification right now.")));
        }

        if (isset($_POST['message'], $_POST['id'])) {
            $state = $db->prepare("SELECT * FROM threads WHERE id = ?");
            $state->execute(array($_POST['id']));
            $thread = $state->fetchAll()[0];
            if ($thread['team_id'] != $_SESSION['team_id']) {
                if (!isAdmin())
                    die(json_encode(array("error" => "You cannot reply to this clarification right now.")));
            }

            $state = $db->prepare("INSERT INTO replies (thread_id, poster_id, message, post_time) VALUES (?, ?, ?, ?)");
            $state->execute(array($_POST['id'], $_SESSION['team_id'], htmlspecialchars($_POST['message']), time()));
            die(json_encode(array("success" => "Your reply has been posted.", "id" => $db->lastInsertId())));
        } else {
            die(json_encode(array("error" => "Please fill out all fields.")));
        }

    } else {
        die(json_encode(array("error" => "Action not found.")));
    }
} else {
    die(json_encode(array("error" => "You must provide a request type.")));
}