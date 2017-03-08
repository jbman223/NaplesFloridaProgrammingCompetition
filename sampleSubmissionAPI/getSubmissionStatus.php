<?php
require_once("../require.php");
require_once("../competitionSite/assets/sphereEngine.php");

if (isset($_SESSION['codeSessionLink'])) {
    $status = submissionStatus($_SESSION['codeSessionLink']);
    if ($status['status'] == 0) {
        die(json_encode(array("success" => "Fetching your program's information.")));
    } else {
        die(json_encode(array("wait" => "Waiting for your code to be compiled...")));
    }
} else {
    die(json_encode(array("error" => "Please create a code submission first.")));
}
