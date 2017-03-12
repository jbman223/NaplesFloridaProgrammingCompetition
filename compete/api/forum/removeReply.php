<?php
require_once "../../content/require.php";
if (!isUserLoggedIn()) {
    die(json_encode(array("error" => "Please refresh the page.")));
}
if (!$user['admin']) {
    die(json_encode(array("error" => "You do not have permission.")));
}

if (isset($_GET['id'])) {
    $state = $db->prepare("update replies set deleted = true where id = ?");
    $state->execute(array($_GET['id']));

    die(json_encode(array("success" => "Reply deleted.")));
} else {
    die(json_encode(array("error" => "ID Not received.")));
}
