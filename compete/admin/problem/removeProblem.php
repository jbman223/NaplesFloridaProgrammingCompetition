<?php
require_once "../../content/require.php";

if (!isUserLoggedIn()) {
    header("Location: account/login.php");
}
if (!$user['admin']) {
    header("Location: account/login.php");
}

if (isset($_GET['id'])) {
    $state = $db->prepare("update problem_data set removed = true where id = ?");
    $state->execute(array($_GET['id']));
    header("location: problemList.php");
} else {
    header("location: problemList.php");
}