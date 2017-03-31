<?
require_once "require.php";
if (isset($_SESSION['currentProblem'])) {
    $state = $db->prepare("select * from edu_problems where id = ?");
    $state->execute(array($_SESSION['currentProblem']));

    $problems = $state->fetchAll(PDO::FETCH_ASSOC);

    $currentProblem = $problems[0];
    die(json_encode(array("code" => $currentProblem['sample_code'], "input" => $currentProblem['problem_sample_input'])));
}