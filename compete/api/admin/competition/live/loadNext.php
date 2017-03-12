<?php
require_once "../../../../content/require.php";

if (!isUserLoggedIn()) {
    die();
}
if (!$user['admin']) {
    die();
}

$state = $db->prepare("select s.*, t.team_name, p.problem_title, p.problem_input, p.problem_output, p.problem_code, c.code, c.error, c.output from solved_problems s inner join teams t on t.id = s.team_id inner join problem_data p on p.id = s.problem_id inner join code_results c on c.id = s.code_result inner join competition_sections cs on cs.id = s.section_id where cs.competition_id = ? and s.approved = false");
$state->execute(array($_GET['competition_id']));

$results = $state->fetchAll(PDO::FETCH_ASSOC);
if (count($results) > 0) {
    $results = $results[0];
} else {
    ?>
    <h1 class="text-center">Waiting for problems to review...</h1>
    <p class="text-center">
        <img src="http://programmingcompetition.org/images/default.gif" />
    </p>
    <?
    die();
}


?>

<div class="row">
    <div class="col-md-12">
        <h2 class="pull-left"><? echo $results['problem_title'] ?></h2>

        <h3 class="pull-right">Solution by <? echo $results['team_name']; ?></h3>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <p><b>Problem Code</b></p>
                        <pre style="max-height: 300px;overflow-y:auto;"><code
                                class="java github"><? echo htmlspecialchars($results['problem_code']); ?></code></pre>
    </div>
    <div class="col-md-6">
        <p><b><? echo $results['team_name'] ?>'s Code</b></p>
                        <pre style="max-height: 300px;overflow-y:auto;"><code
                                class="java github"><? echo htmlspecialchars($results['code']); ?></code></pre>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <p><b>Problem Input</b></p>
        <pre style="max-height: 150px;overflow-y:auto;"><? echo $results['problem_input']; ?></pre>

        <p><b>Problem Output</b></p>
        <pre style="max-height: 150px;overflow-y:auto;"><? echo $results['problem_output']; ?></pre>

    </div>
    <div class="col-md-4">
        <p><b><? echo $results['team_name'] ?>'s Output</b></p>
        <pre style="max-height: 300px;overflow-y:auto;"><? echo $results['output']; ?></pre>
    </div>
    <div class="col-md-4">
        <p><b>Errors</b></p>
        <pre style="max-height: 300px;overflow-y:auto;"><? echo $results['error']; ?></pre>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <p class="lead pull-left">System
            Decision: <? echo $results['correct'] == 1 ? "<span style='color:green;'>Correct</span>" : "<span style='color:red;'>Incorrect</span>"; ?>
            <a href="#" data-solvedproblemid="<? echo $results['id']; ?>" class="btn btn-danger switch">Switch System Decision</a></p>

        <p class="pull-right">
            <button data-solvedproblemid="<? echo $results['id']; ?>" class="btn btn-primary approve">Approve</button>
        </p>
    </div>
</div>
