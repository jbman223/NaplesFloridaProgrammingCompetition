<?php
require_once "../../../content/require.php";
require_once "../../../codeRunner/internalRun.php";

ignore_user_abort(true);
set_time_limit(0);

if (!isUserLoggedIn()) {
    die();
}
if (!$user['admin']) {
    die();
}

if (isset($_POST['problem_id'], $_POST['section_id'])) {
    $state = $db->prepare("select sp.id, cr.id as code_result_id, cr.code, pd.problem_input, sp.language, pd.problem_output_hash from solved_problems sp inner join code_results cr on cr.id = sp.code_result inner join problem_data pd on pd.id = sp.problem_id  where sp.problem_id = ? and sp.section_id = ?");
    $state->execute(array($_POST['problem_id'], $_POST['section_id']));
    $submissions = $state->fetchAll(PDO::FETCH_ASSOC);

    foreach ($submissions as $submission) {
        $result = json_decode(run($submission['language'], $submission["problem_input"], $submission["code"]));
        $state = $db->prepare("update code_results set error = ?, `output` = ?, run_time = ? where id = ?");
        $state->execute(array($result->errors, $result->output, $result->time, $submission['code_result_id']));

        $formattedOutput = preg_replace('/\s+/', '', $result->output);
        $outputHash = md5($formattedOutput);

        $solved = 0;

        if ($outputHash == $submission['problem_output_hash']) {
            //correct
            $solved = 1;
        }

        $state = $db->prepare("update solved_problems set correct = ?, approved = 0, time = ? where id = ?");
        $state->execute(array($solved, time(), $submission['id']));
    }

    die(json_encode(array("success" => "Rescored ".count($submissions)." submissions.")));
} else {
    die(json_encode(array("error" => "Improper input received.")));
}