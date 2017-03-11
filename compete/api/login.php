<?php
require_once "../content/require.php";

if (isset($_POST['username'], $_POST['password'])) {
    $state = $db->prepare("select * from teams where backendLogin = ?");
    $state->execute(array($_POST['username']));

    $users = $state->fetchAll(PDO::FETCH_ASSOC);

    if (count($users) > 0 && $_POST['password'] == $users[0]['backendPassword']) {
        $_SESSION['competition_site_id'] = $users[0]['id'];
        die(json_encode(array("success" => "The user has logged in successfully.")));
    } else {
        die(json_encode(array("error" => "The user was not found.")));
    }
} else {
    die(json_encode(array("error" => "Improper request.")));
}