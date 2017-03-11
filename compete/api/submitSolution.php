<?php
require_once "../content/require.php";
require_once "../codeRunner/internalRun.php";

if (!isUserLoggedIn()) {
    die(json_encode(array("error" => "You are not logged in. Please refresh the page.")));
}

if (isset($_POST['section_id'], $_POST['code'], $_POST['problem_id'], $_POST['language'])) {
    $state = $db->prepare("select * from competition_sections where id = ?");
    $state->execute(array($_POST['section_id']));
    $section = $state->fetchAll(PDO::FETCH_ASSOC);

    if (count($section) > 0) {
        $section = $section[0];
        if ($section['start'] >= time() || $section['end'] <= time()) {
            die(json_encode(array("error" => "The section has ended.")));
        }

        $state = $db->prepare("select * from solved_problems where problem_id = ? and section_id = ? and team_id = ? and correct = true");
        $state->execute(array($_POST['problem_id'], $section['id'], $user['id']));
        if (count($state->fetchAll(PDO::FETCH_ASSOC)) > 0) {
            die(json_encode(array("error" => "You have already solved this problem.")));
        }

        $state = $db->prepare("select * from problem_data where id = ?");
        $state->execute(array($_POST['problem_id']));
        $problem = $state->fetchAll(PDO::FETCH_ASSOC);
        if (count($problem) > 0) {
            $problem = $problem[0];
            $state = $db->prepare("select * from competition_section_problems where problem_id = ? and section_id = ?");
            $state->execute(array($problem['id'], $section['id']));
            if (count($state->fetchAll(PDO::FETCH_ASSOC)) < 1) {
                die(json_encode(array("error" => "The problem was not found in that section.")));
            }
        }  else {
            die(json_encode(array("error" => "The problem was not found.")));
        }

        $result = json_decode(run($_POST['language'], $problem["problem_input"], $_POST["code"]));
        $state = $db->prepare("insert into code_results (code, code_hash, error, `output`, run_time) values (?, ?, ?, ?, ?)");
        $state->execute(array($_POST['code'], md5($_POST['code']), ($result->errors==null)?"":$result->errors, ($result->output==null)?"error":$result->output, ($result->time==null)?0:$result->time));
        $lastID = $db->lastInsertId();

        $formattedOutput = preg_replace('/\s+/', '', $result->output);
        $outputHash = md5($formattedOutput);

        $solved = 0;

        if ($outputHash == $problem['problem_output_hash']) {
            //correct
            $solved = 1;
        }

        $state = $db->prepare("insert into solved_problems (team_id, problem_id, section_id, time, code_result, correct, `language`) values (?, ?, ?, ?, ?, ?, ?)");
        $state->execute(array($user['id'], $problem['id'], $section['id'], time(), $lastID, $solved, $_POST['language']));

        if (strstr($outputHash, "Compilation Error")) {
            die(json_encode(array("error" => "Your code did not compile.")));
        }

        if ($solved) {
            die(json_encode(array("success" => "You solved the problem successfully.")));
        } else {
            die(json_encode(array("error" => "Your code did not solve the problem correctly.")));
        }
    } else {
        die(json_encode(array("error" => "The section was not found.")));
    }
}