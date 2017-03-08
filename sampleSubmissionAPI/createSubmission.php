<?php
require_once("../require.php");
require_once("../competitionSite/assets/sphereEngine.php");

if (isset($_SESSION['codeSessionLink'])) {
    die(json_encode(array("success" => $_SESSION['codeSessionLink'])));
}

if (isset($_POST['code'], $_POST['language'], $_POST['problem'])) {
    $code = str_replace("public class", "class", $_POST['code']);
    $codemd5 = md5($code);
    $state = $db->prepare("SELECT *, COUNT(*) FROM sampleSubmissions WHERE code_hash = ?");
    $state->execute(array($codemd5));
    $exists = $state->fetchAll()[0];
    if ($exists['COUNT(*)'] == 0) {
        //Send to ideone and get the link back to the client
        $_SESSION['codeSessionProblem'] = $_POST['problem'];
        if ($_POST['problem'] == 1) {
            $result = submitCode($code, $_POST['language'], file_get_contents("../downloads/sampleProblems/iPodSimulator/input.txt"));
            if ($result['error'] == "OK") {
                $_SESSION['codeSessionLink'] = $result['link'];
                die(json_encode(array("success" => $result['link'])));
            } else {
                die(json_encode(array("error" => "Error running code: ".$result['error'])));
            }
        } else {
            $result = submitCode($code, $_POST['language'], file_get_contents("../downloads/sampleProblems/Jimmy/JimmyInput.txt"));
            if ($result['error'] == "OK") {
                $_SESSION['codeSessionLink'] = $result['link'];
                die(json_encode(array("success" => $result['link'])));
            } else {
                die(json_encode(array("error" => "Error running code: ".$result['error'])));
            }
        }
    } else {
        die(json_encode(array("error" => "That code has already been submitted! View it <a href=\"http://ideone.com/".$exists['link']."\" target='_blank'>here.</a>")));
    }
} else {
    die(json_encode(array("error" => "You must submit code and the language.")));
}