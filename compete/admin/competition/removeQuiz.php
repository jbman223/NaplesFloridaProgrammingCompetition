<?php
require_once "../../content/require.php";

if (!isUserLoggedIn()) {
    header("Location: account/login.php");
}
if (!$user['admin']) {
    header("Location: account/login.php");
}

if (isset($_GET['id'])) {
    $state = $db->prepare("update section_quizzes set removed = true where id = ?");
    $state->execute(array($_GET['id']));
    header("location: competition.php?id=".$_GET['competition_id']);
} else {
    header("location: competitionList.php");
}