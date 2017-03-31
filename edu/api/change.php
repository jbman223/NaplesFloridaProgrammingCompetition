<?php
require_once "require.php";
if (!isUserLoggedIn()) {
    header("Location: ../landingPage.php");
    die();
}

if (isset($_GET['id'])) {
    $_SESSION['currentProblem'] = $_GET['id'];
}
header("Location: ".$_SERVER['HTTP_REFERER']);
die();