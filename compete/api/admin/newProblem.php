<?php
require_once "../../content/require.php";

if (!isUserLoggedIn()) {
    die();
}
if (!$user['admin']) {
    die();
}

if (isset($_POST["problem_name"], $_POST["problem_description"], $_POST["problem_sample_input"], $_POST["problem_sample_output"], $_POST['problem_input'], $_POST['problem_output'], $_POST["code"])) {
    $formattedOutput = preg_replace('/\s+/', '', $_POST['problem_output']);
    $outputHash = md5($formattedOutput);
    $languages = array("java", "python");

    if (in_array($_POST['problem_language'], $languages)) {
        die(json_encode(array("error" => "Language not supported.")));
    }

    if (isset($_POST['id'])) {
        //initiate update procedure
        $state = $db->prepare("update problem_data set problem_title = ?, problem_description = ?, problem_sample_input = ?, problem_sample_output = ?, problem_input = ?, problem_output = ?, problem_output_trimmed = ?, problem_output_hash = ?, problem_code = ?, problem_code_hash = ?, problem_code_language = ? where id = ?");
        $state->execute(array($_POST["problem_name"], $_POST["problem_description"], $_POST["problem_sample_input"], $_POST["problem_sample_output"], $_POST['problem_input'], $_POST['problem_output'], $formattedOutput, $outputHash, $_POST["code"], md5($_POST['code']), $_POST['problem_language'], $_POST['id']));
        die(json_encode(array("success" => "Problem successfully updated.")));
    } else {
        //create brand new problem
        $state = $db->prepare("insert into problem_data (problem_title, problem_description, problem_sample_input, problem_sample_output, problem_input, problem_output, problem_output_trimmed, problem_output_hash, problem_code, problem_code_hash, problem_code_language) values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $state->execute(array($_POST["problem_name"], $_POST["problem_description"], $_POST["problem_sample_input"], $_POST["problem_sample_output"], $_POST['problem_input'], $_POST['problem_output'], $formattedOutput, $outputHash, $_POST["code"], md5($_POST['code']), $_POST['problem_language']));
        die(json_encode(array("success" => "Problem successfully added to the database.")));
    }
} else if (isset($_GET['id'])) {
    $state = $db->prepare("select * from problem_data where id = ?");
    $state->execute(array($_GET['id']));
    $problem = $state->fetchAll(PDO::FETCH_ASSOC);

    if (count($problem) == 1) {
        die(json_encode($problem[0]));
    } else {
        die(json_encode(array("error" => "No problem found.")));
    }
} else {
    die(json_encode(array("error" => "All required fields were not received.")));
}