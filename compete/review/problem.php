<?php
require_once "../content/require.php";

if (!isset($_GET['problemId'], $_GET['email'], $_GET['password'])) {
    //header("Location: ../../index.php");
    die("Invalid request.");
}

//authenticate request.
$state = $db->prepare("select * from reviewers where email_address = ? and problem_id = ? and password = ?");
$state->execute(array($_GET['email'], $_GET['problemId'], md5($_GET['password'])));
$review = $state->fetchAll(PDO::FETCH_ASSOC);

if (count($review) > 0) {
    $review = $review[0];
} else {
    //header("Location: ../../index.php");
    die("No review found");
}

$state = $db->prepare("select * from problem_data where id = ?");
$state->execute(array($review['problem_id']));
$problem = $state->fetchAll(PDO::FETCH_ASSOC)[0];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Review Problem</title>


    <link rel="stylesheet" href="../../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/site.css">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.2.0/styles/default.min.css">

    <script src="http://programmingcompetition.org/compete/jquery.min.js"></script>
    <script src="../../js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.2.0/highlight.min.js"></script>
    <script>hljs.initHighlightingOnLoad();</script>

    <script src="http://ws.programmingcompetition.org:8080/socket.io/socket.io.js"></script>

    <? echo $gaCode; ?>
</head>

<body>

<div class="container-fluid">

    <? require_once "../../content/menu.php"; ?>

    <div class="bg-container">
        <div class="row">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 hover-top" style="background: white;">
                        <h1 class="pull-left" style="margin-top:0;">
                            Review Center (Reviewing "<? echo $problem['problem_title']; ?>")
                        </h1>

                        <div class="btn-group pull-right" role="group" aria-label="...">
                            <a type="button" href="#" data-id="<? echo $problem['id']; ?>" data-password="<? echo $_GET['password'] ?>" id="competitor_view"
                               class="btn btn-default">Competitor View</a>
                            <a type="button" href="#" class="btn btn-success">Save Review</a>
                        </div>
                    </div>
                </div>

                <!-- PAGE CONTENT HERE -->

                <div class="row">
                    <div class="col-md-12">

                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h3 class="panel-title">Your Review</h3>
                            </div>
                            <div class="panel-body">
                                Welcome to the review center. You have been chosen to double check that this problem is
                                valid for the competition, meaning that it has no obvious typos or logical errors. This
                                is a super simple task. All that we ask is that you <b>read the problem
                                    description</b><? echo ($review['review_type'] == 1) ? " and <b>solve the problem code</b>" : ""; ?>
                                then give us your feedback. You can read the problem on this page, and type your
                                feedback in the feedback box below. Press the green save button to save your progress.
                                Once you are finished, you can click the finished button below to finalize your review.

                                <form class="pull-right">
                                    <div class="input-group ">
                                        <button class="btn btn-primary">Finalize Review</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">

                    <div class="col-md-9">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">Problem Description</h3>
                            </div>
                            <div class="panel-body" style="max-height: 400px; overflow-y:scroll;">
                                <? echo $problem['problem_description']; ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">Problem I/O</h3>
                            </div>
                            <div class="panel-body" style="max-height: 400px; overflow-y:scroll;">

                                <b>SAMPLE INPUT</b>
                                <pre><? echo $problem['problem_sample_input']; ?></pre>


                                <b>SAMPLE OUTPUT</b>
                                <pre><? echo $problem['problem_sample_output']; ?></pre>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <form>
                            <div class="form-group">
                                <label for="review_notes">Review Notes</label>
                                <textarea id="review_notes" name="review_notes" class="form-control" rows="3"></textarea>
                                <p class="help-block">Write your thoughts about the problem here. Make sure to include any errors you find in the sample input, sample output, or the writeup.</p>
                            </div>
                            <div class="form-group">
                                <a type="button" href="#" class="btn btn-success">Save Review</a>
                            </div>
                        </form>
                    </div>
                </div>

                <hr/>

                <div class="row">

                    <div class="col-md-12">

                        <? if ($review['review_type'] == 1) {
                            ?>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Problem Code</h3>
                                </div>
                                <div class="panel-body">
                                    <div class="container-fluid">
                                        <div class="col-md-7">
                                            <h3>Submit Your Solution</h3>

                                            <form>
                                                <div class="form-group">
                                                    <label for="review_notes">Enter Your Code</label>
                                                    <textarea id="review_notes" name="review_notes" class="form-control" rows="8"></textarea>
                                                    <p class="help-block">Paste your code here. Do not include a package.</p>
                                                </div>
                                                <div class="form-group">
                                                    <a type="button" href="#" class="btn btn-success">Run Code</a>
                                                </div>
                                            </form>

                                        </div>
                                        <div class="col-md-5">
                                            <h3>Problem Solution</h3>
                                            <pre style="max-height: 200px; overflow-y:scroll;"><code
                                                    class="java github"><? echo htmlspecialchars($problem['problem_code']); ?></code></pre>
                                            <p class="lead">
                                                <b>Code Ran: </b><? echo $problem['problem_code_ran'] == 1 ? "YES" : "NO"; ?>
                                                <br/>
                                                <b>RESULTS: </b><? echo status($problem["problem_code_status"])[0]; ?><br/>
                                            </p>
                                        </div>
                                    </div>

                                    <hr />

                                    <div class="container-fluid">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <h3>Your Code Results</h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?
                        } else {
                            ?>
                            <h1>No code review required.</h1>
                            <?
                        } ?>

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
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<script src="../js/reviewProblem.js"></script>
</body>
</html>
