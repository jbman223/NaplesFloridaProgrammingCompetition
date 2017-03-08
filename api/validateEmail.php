<?php
require_once ("../require.php");
if (isset($_GET['email'], $_SESSION['quiz_edit_session']) && filter_var($_GET['email'], FILTER_VALIDATE_EMAIL))
    die(json_encode(array("success" => "valid email")));
else {
    die(json_encode(array("error" => "email not valid")));
}