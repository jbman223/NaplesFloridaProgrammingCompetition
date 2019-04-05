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

$state = $db->prepare("select * from quizzes where id = ?");
$state->execute(array($_GET['id']));

$quiz = $state->fetchAll(PDO::FETCH_ASSOC);
if (count($quiz) == 0) {
    header("Location: index.php");
}
$quiz = $quiz[0];

$state = $db->prepare("select * from quiz_questions where quiz_id = ? and removed = false");
$state->execute(array($quiz['id']));

$questions = $state->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Quiz</title>


    <link rel="stylesheet" href="../../../css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/site.css">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.2.0/styles/default.min.css">

    <script src="http://programmingcompetition.org/compete/jquery.min.js"></script>
    <script src="../../../js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.2.0/highlight.min.js"></script>

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
                            <li><a href="index.php">Quiz Center</a></li>
                            <li><a href="quizList.php">Quiz List</a></li>
                            <li class="active"><? echo $quiz['quiz_name']; ?></li>
                        </ol>

                        <h1 class="pull-left" style="margin-top:0;">
                            <? echo $quiz['problem_title']; ?>
                        </h1>

                        <div class="btn-group pull-right" role="group" aria-label="...">
                            <a type="button" href="newQuiz.php?id=<? echo $quiz['id']; ?>" class="btn btn-default">Edit Quiz</a>
                            <a type="button" href="<? echo $quiz['id']; ?>" id="competitor_view" class="btn btn-default">View Statistics</a>
                            <a type="button" href="removeQuiz.php" class="btn btn-danger">Delete Quiz</a>
                        </div>
                    </div>
                </div>

                <!-- PAGE CONTENT HERE -->

                <div class="row">
                    <div class="col-md-3">

                    </div>

                    <div class="col-md-9">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title"><? echo $quiz['quiz_name']; ?> Questions</h3>
                            </div>
                            <div class="panel-body">
                                <?
                                    if (count($questions) == 0) {
                                        ?>
                                            <h4>No questions yet!</h4>
                                            <p>
                                                <a href="newQuestion.php?id=<? echo $quiz['id']; ?>">Add one</a>
                                            </p>
                                        <?
                                    } else {
                                        ?>
                                        <table class="table table-bordered">
                                            <tr>
                                                <th>Question #</th>
                                                <th>Question Picture</th>
                                                <th>Answer</th>
                                                <th>Edit</th>
                                                <th>Remove</th>
                                            </tr>

                                            <?
                                            foreach ($questions as $question) {
                                                ?>
                                                <tr>
                                                    <td><? echo $question['id']; ?></td>
                                                    <td><img src="<? echo $question['picture']; ?>" style="max-width: 350px;" /></td>
                                                    <td><? echo $question['answer']; ?></td>
                                                    <td><a href="newQuestion.php?id=<? echo $quiz['id'] ?>&question_id=<? echo $question['id']; ?>">Edit</a></td>

                                                    <td><a href="removeQuestion.php?id=<? echo $question['id'] ?>">Remove</a></td>
                                                </tr>
                                                <?
                                            }
                                            ?>
                                        </table>
                                        <?
                                    }
                                ?>
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
</body>
</html>