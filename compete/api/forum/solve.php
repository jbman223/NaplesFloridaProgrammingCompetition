<?php
require_once "../../content/require.php";

if (!isUserLoggedIn()) {
    die(json_encode(array("error" => "Please refresh the page.")));
}
if (!$user['admin']) {
    die(json_encode(array("error" => "You do not have permission.")));
}

if (isset($_GET['id'])) {
    $state = $db->prepare("update threads set solved = not solved  where id = ?");
    $state->execute(array($_GET['id']));

    die(json_encode(array("success" => "Solve toggled.")));
} else {
    die(json_encode(array("error" => "ID Not received.")));
}
