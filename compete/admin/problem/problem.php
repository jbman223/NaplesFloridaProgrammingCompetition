<?php
require_once "../../content/require.php";

if (!isUserLoggedIn()) {
    header("Location: ../../account/login.php");
}
if (!$user['admin']) {
    header("Location: ../../account/login.php");
}
if (!isset($_GET['id'])) {
    header("Location: ../../account/login.php");
}

start:

$state = $db->prepare("select * from problem_data where id = ?");
$state->execute(array($_GET['id']));

$problem = $state->fetchAll(PDO::FETCH_ASSOC);
if (count($problem) == 0) {
    header("Location: index.php");
}
$problem = $problem[0];


if ($problem['problem_code_hash'] == "") {
    $hash = md5($problem['problem_code']);
    $state = $db->prepare("update problem_data set problem_code_hash = ? where id = ?");
    $state->execute(array($hash, $problem['id']));
    goto start;
}

$codeResult = false;

if ($problem['problem_code_result'] != 0) {
    $state = $db->prepare("select * from code_results where id = ?");
    $state->execute(array($problem['problem_code_result']));
    $codeResult = $state->fetchAll(PDO::FETCH_ASSOC)[0];
}

if ($codeResult) {
    if ($codeResult['code_hash'] != $problem['problem_code_hash']) {
        if ($problem['problem_status'] == 2) {
            $problem['problem_status'] = 1;
        }
        $state = $db->prepare("update problem_data set problem_code_ran = 0, problem_code_result = 0, problem_code_status = 0, problem_status = ? where id = ?");
        $state->execute(array($problem['problem_status'], $problem['id']));
        goto start;
    }
}

$state = $db->prepare("select id, email_address, review_complete from reviewers where problem_id = ?");
$state->execute(array($problem['id']));
$reviewers = $state->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Problem</title>


    <link rel="stylesheet" href="../../../css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/site.css">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.2.0/styles/default.min.css">

    <script src="http://programmingcompetition.org/compete/jquery.min.js"></script>
    <script src="../../../js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.2.0/highlight.min.js"></script>
    <script>hljs.initHighlightingOnLoad();</script>

    <? echo $gaCode; ?>
</head>

<body>

<div class="container-fluid">

    <? require_once "../../content/menu.php"; ?>

    <div class="bg-container">
        <div class="row">
            <div class="container">

                <div class="row">
                    <div class="col-md-12">
                        <ol class="breadcrumb">
                            <li><a href="../">Administration</a></li>
                            <li><a href="index.php">Problem Center</a></li>
                            <li><a href="problemList.php">Problem List</a></li>
                            <li class="active"><? echo $problem['problem_title']; ?></li>
                        </ol>

                        <h1 class="pull-left" style="margin-top:0;">
                            <? echo $problem['problem_title']; ?>
                        </h1>

                        <div class="btn-group pull-right" role="group" aria-label="...">
                            <a type="button" href="newProblem.php?id=<? echo $problem['id']; ?>" class="btn btn-default">Edit Problem</a>
                            <a type="button" href="#" data-id="<? echo $problem['id']; ?>" id="competitor_view" class="btn btn-default">Competitor View</a>
                            <a type="button" href="#" class="btn btn-danger">Delete Problem</a>
                        </div>
                    </div>
                </div>

                <!-- PAGE CONTENT HERE -->

                <div class="row">
                    <div class="col-md-3">
                        <div class="panel text-center panel-<? echo status($problem['problem_status'])[1]; ?>">
                            <div class="panel-heading">
                                <h3 class="panel-title">Problem Status</h3>
                            </div>
                            <div class="panel-body">
                                <? echo status($problem['problem_status'])[0]; ?>
                            </div>
                        </div>

                        <div class="panel text-center panel-<? echo status($problem['problem_code_status'])[1]; ?>">
                            <div class="panel-heading">
                                <h3 class="panel-title">Code Status</h3>
                            </div>
                            <div class="panel-body">
                                <? echo status($problem['problem_code_status'])[0]; ?><br/>
                                <a href="#" id="compile_code" data-id="<? echo $problem['id']; ?>"
                                   class="btn btn-sm btn-primary">Re-Test Code</a>
                            </div>
                        </div>

                        <!--<div class="panel text-center panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">Send Review Request</h3>
                            </div>
                            <div class="panel-body">
                                <form class="review-request">
                                    <div class="form-group text-left">
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="review" id="review1" value="code">
                                                I/O Review
                                            </label>
                                        </div>
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="review" id="review2" value="description">
                                                Problem Description Review
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <input class="form-control" type="text" name="email" placeholder="Email Address" />
                                        <input type="hidden" name="problem_id" value="<?/* echo $problem['id']; */?>" />
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">Add</button>
                                    </div>
                                </form>

                                <?/*
                                if (count($reviewers) > 0) {
                                    $state = $db->prepare("select * from reviewers where review_complete = 1 and problem_id = ?");
                                    $state->execute(array($problem['id']));

                                    $reviewsComplete = count($state->fetchAll(PDO::FETCH_ASSOC));
                                    */?>
                                    <p>
                                        <small class="pull-right <?/* echo ($reviewsComplete > 7)?"text-success":"text-danger"; */?>"><?/* echo $reviewsComplete; */?>/8 Reviews Complete</small>
                                    </p>
                                <?/*
                                }
                                */?>
                            </div>

                            <?/* if (count($reviewers) > 0) {
                                */?>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Reviewer</th>
                                            <th>Complete</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?/* foreach ($reviewers as $reviewer) {
                                            */?>
                                            <tr>
                                                <td><a href="#"><?/* echo $reviewer['email_address']; */?></a></td>
                                                <td><?/* echo ($reviewer['review_complete'] == 1)?"<span class='glyphicon glyphicon-ok'></span>":"<span class='glyphicon glyphicon-remove'></span>"; */?></td>
                                            </tr>
                                            <?/*
                                        } */?>
                                    </tbody>
                                </table>
                                <?/*
                            } */?>
                        </div>-->
                    </div>

                    <div class="col-md-9">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">Problem Description</h3>
                            </div>
                            <div class="panel-body" style="max-height: 200px; overflow-y:scroll;">
                                <? echo $problem['problem_description']; ?>
                            </div>
                        </div>

                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">Problem I/O</h3>
                            </div>
                            <div class="panel-body">
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-md-1">
                                        </div>
                                        <div class="col-md-5">
                                            <b>SAMPLE INPUT</b>
                                            <pre><? echo $problem['problem_sample_input'];  ?></pre>

                                            <b>SAMPLE OUTPUT</b>
                                            <pre><? echo $problem['problem_sample_output'];  ?></pre>
                                        </div>
                                        <div class="col-md-5">
                                            <b>INPUT</b>
                                            <pre><? echo $problem['problem_input'];  ?></pre>

                                            <b>OUTPUT</b>
                                            <pre><? echo $problem['problem_output'];  ?></pre>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">Problem Code</h3>
                            </div>
                            <div class="panel-body">
                                <pre style="max-height: 200px; overflow-y:scroll;"><code class="java github"><? echo htmlspecialchars($problem['problem_code']); ?></code></pre>
                                <p class="lead">
                                    <b>Code Hash: </b><? echo $problem['problem_code_hash']; ?><br />
                                    <b>Code Ran: </b><? echo $problem['problem_code_ran'] == 1?"YES":"NO"; ?><br />
                                    <b>RESULTS:</b><br />
                                </p>
                                <? if ($codeResult) { ?>
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <b>EXPECTED OUTPUT</b>
                                            <pre><? echo $problem['problem_output'];  ?></pre>
                                        </div>
                                        <div class="col-md-4">
                                            <b>PRODUCED OUTPUT</b>
                                            <pre><? echo $codeResult['output'];  ?></pre>
                                        </div>
                                        <div class="col-md-4">
                                            <b>ERRORS</b>
                                            <pre><? echo $codeResult['error'];  ?></pre>
                                        </div>
                                    </div>
                                </div>
                                <? } ?>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>




    </div>

    <div class="modal fade code-display" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body code-area">

                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <script src="../../js/problem.js"></script>
</body>
</html>