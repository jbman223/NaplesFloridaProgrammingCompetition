<?php
require_once "../content/require.php";

if (!isUserLoggedIn()) {
    header("Location: index.php");
    die();
}


if (!isset($_GET['id'])) {
    header("Location: index.php");
    die();
}

$state = $db->prepare("select sp.correct, sp.team_id, sp.id, sp.time, sp.language, cr.code, cr.output, cr.error, pd.problem_title, pd.problem_input, pd.problem_output, pd.problem_code from solved_problems sp inner join code_results cr on cr.id = sp.code_result inner join problem_data pd on pd.id = sp.problem_id where sp.id = ?");
$state->execute(array($_GET['id']));

$submission = $state->fetchAll(PDO::FETCH_ASSOC);

if (count($submission) != 1) {
    header("Location: index.php");
    die();
}
$submission = $submission[0];

if ($submission['team_id'] != $user['id']) {
    header("Location: index.php");
    die();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>View Submission</title>


    <link rel="stylesheet" href="../../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/site.css">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.2.0/styles/default.min.css">


    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="../../js/bootstrap.min.js"></script>

    <script src="http://159.203.168.143:8080/socket.io/socket.io.js"></script>

    <script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.2.0/highlight.min.js"></script>

    <script>hljs.initHighlightingOnLoad();</script>

    <? echo $gaCode; ?>
</head>

<body>

<div class="container-fluid">

    <? require_once "../content/menu.php"; ?>

    <div class="bg-container">
        <div class="row">
            <div class="container">


                <div class="row">
                    <div class="col-md-12">
                        <!-- PAGE CONTENT HERE -->
                        <ol class="breadcrumb">
                            <li><a href="index.php">Statistics</a></li>
                            <li class="active">View Submission</li>
                        </ol>

                        <h1>View Submission - <? echo $user['team_name'] ?> - <? echo $submission['problem_title'] ?></h1>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <p><b>Problem Code</b></p>
                        <pre style="max-height: 300px;overflow-y:auto;"><code
                                class="java github"><? echo htmlspecialchars($submission['problem_code']); ?></code></pre>
                    </div>
                    <div class="col-md-6">
                        <p><b><? echo $user['team_name'] ?>'s Code</b></p>
                        <pre style="max-height: 300px;overflow-y:auto;"><code
                                class="java github"><? echo htmlspecialchars($submission['code']); ?></code></pre>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <p><b>Problem Input</b>
                        <pre style="max-height: 150px;overflow-y:auto;"><? echo $submission['problem_input']; ?></pre>

                        <p><b>Problem Output</b></p>
                        <pre style="max-height: 150px;overflow-y:auto;"><? echo $submission['problem_output']; ?></pre>

                    </div>
                    <div class="col-md-4">
                        <p><b><? echo $user['team_name'] ?>'s Output</b></p>
                        <pre style="max-height: 300px;overflow-y:auto;"><? echo $submission['output']; ?></pre>
                    </div>
                    <div class="col-md-4">
                        <p><b>Errors</b></p>
                        <pre style="max-height: 300px;overflow-y:auto;"><? echo $submission['error']; ?></pre>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <p class="lead pull-left">System
                            Decision: <? echo $submission['correct'] == 1 ? "<span style='color:green;'>Correct</span>" : "<span style='color:red;'>Incorrect</span>"; ?></p>
                    </div>
                </div>
            </div>
        </div>


    </div>
</body>
</html>