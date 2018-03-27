<?php
require_once "../../content/require.php";
require_once "../../codeRunner/internalRun.php";

if (!isUserLoggedIn()) {
    die();
}
if (!$user['admin']) {
    die();
}

if (isset($_POST['id'])) {
    $state = $db->prepare("select * from problem_data where id = ?");
    $state->execute(array($_POST['id']));
    $problem = $state->fetchAll(PDO::FETCH_ASSOC);
    if (count($problem) != 0) {
        $problem = $problem[0];
        if ($problem["problem_code"] != "" && $problem["problem_input"] != "") {
            $result = json_decode(run("java", $problem["problem_input"], $problem["problem_code"]));

	    if ($result == null) {
		die(json_encode(array("error" => "Result is null!")));
	    }

	    // die(json_encode(array("error" => $result)));
	 
            $state = $db->prepare("insert into code_results (code, code_hash, error, `output`, run_time) values (?, ?, ?, ?, ?)");
            $state->execute(array($problem["problem_code"], $problem["problem_code_hash"], $result->message->type=="success"?"":$result->message->data, implode("\n", $result->stdouts), $result->message->data));
            $lastID = $db->lastInsertId();
            $status = 0;
            $problemStatus = 0;

            $formattedOutput = preg_replace('/\s+/', '', implode("\n", $result->stdouts));
            $outputHash = md5($formattedOutput);

            if ($outputHash != $problem['problem_output_hash']) {
                $status = -2;
                $problemStatus = 0;
            } else {
                $status = 2;
                $problemStatus = 2;
            }

            if ($result->errors != "") {
                $problemStatus = 0;
                $status = -1;
            }

            $state = $db->prepare("update problem_data set problem_code_ran = 1, problem_code_status = ?, problem_code_result = ?, problem_status = ? where id = ?");
            $state->execute(array($status, $lastID, $problemStatus, $problem['id']));

            die(json_encode(array("success" => $lastID)));
        }
    }

    die(json_encode(array("error" => "Problem ID not found.")));
}

