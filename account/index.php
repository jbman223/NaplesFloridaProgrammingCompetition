<?php
require_once "../require.php";

if (isset($_SESSION['id'])) {
    if (isset($_SESSION['redirect'])) {
        header("Location: ".$_SESSION['redirect']);
        unset($_SESSION['redirect']);
    } else {
        header('location: ../index.php');
    }
} else {
    header("Location: login.php");
}
