<?php
require_once("../require.php");
require_once("../competitionSite/assets/sphereEngine.php");

if (isset($_SESSION['codeSessionLink'])) {
    $status = submissionResult($_SESSION['codeSessionLink']);
    if ($status['error'] == 'OK') {
        if ($status['status'] == 0) {
            $state = $db->prepare("INSERT INTO sampleSubmissions (code, compiler_status, `output`, error_info, output_hash, link, problem_id, code_hash) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $state->execute(array($status['source'], $status['result'], $status['output'], $status['cmpinfo'], md5($status['output']), $_SESSION['codeSessionLink'], $_SESSION['codeSessionProblem'], md5($status['source'])));
            if ($status['result'] == 0 || $status['result'] == 15) {
                if ($_SESSION['codeSessionProblem'] == 1) {
                    //ipod
                    if (md5($status['output']) == md5(file_get_contents("../downloads/sampleProblems/iPodSimulator/output.txt"))) {
                        unset($_SESSION['codeSessionProblem']);
                        $link = $_SESSION['codeSessionLink'];
                        unset($_SESSION['codeSessionLink']);
                        die(json_encode(array("success" => "You submitted a correct response to the problem! To view your solution click <a href='http://ideone.com/".$link."'>here</a>.")));
                    } else {
                        unset($_SESSION['codeSessionProblem']);
                        $link = $_SESSION['codeSessionLink'];
                        unset($_SESSION['codeSessionLink']);
                        die(json_encode(array("error" => "Your output did not match the solution! Please check your code and resubmit. To view your solution click <a href='http://ideone.com/".$link."'>here</a>.")));
                    }
                } else {
                    //jimmy
                    if (md5($status['output']) == md5(file_get_contents("../downloads/sampleProblems/Jimmy/output.txt"))) {
                        unset($_SESSION['codeSessionProblem']);
                        $link = $_SESSION['codeSessionLink'];
                        unset($_SESSION['codeSessionLink']);
                        die(json_encode(array("success" => "You submitted a correct response to the problem! To view your solution click <a href='http://ideone.com/".$link."'>here</a>.")));
                    } else {
                        unset($_SESSION['codeSessionProblem']);
                        $link = $_SESSION['codeSessionLink'];
                        unset($_SESSION['codeSessionLink']);
                        die(json_encode(array("error" => "Your output did not match the solution! Please check your code and resubmit. To view your solution click <a href='http://ideone.com/".$link."'>here</a>.")));
                    }
                }

            } else {
                if ($status['result'] == 11 || $status['result'] == 12) {
                    unset($_SESSION['codeSessionProblem']);
                    unset($_SESSION['codeSessionLink']);
                    die(json_encode(array("error" => "Your program contained an error. Error:<strong><br>".nl2br($status['stderr'])."</strong>")));
                } else {
                    unset($_SESSION['codeSessionProblem']);
                    unset($_SESSION['codeSessionLink']);
                    die(json_encode(array("error" => $submissionStatus[$status['result']])));
                }
            }
        } else {
            die(json_encode(array("error" => "Program not completed running.")));
        }
    } else {
        die(json_encode(array("error" => $status['error'])));
    }
} else {
    die(json_encode(array("error" => "Please create a code submission first.")));
}
