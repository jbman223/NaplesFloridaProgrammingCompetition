<?php
require_once "../../content/require.php";

if (!isUserLoggedIn()) {
    header("Location: account/login.php");
}
if (!$user['admin']) {
    header("Location: account/login.php");
}

if (isset($_GET['id'])) {
    $state = $db->prepare("update competitions set removed = true where id = ?");
    $state->execute(array($_GET['id']));
    header("location: competitionList.php");
} else {
    header("location: competitionList.php");
}