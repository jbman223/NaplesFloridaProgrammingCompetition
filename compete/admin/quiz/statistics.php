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

$state = $db->prepare("select * from quiz_questions where quiz_id = ?");
$state->execute(array($quiz['id']));
$questions = $state->fetchAll(PDO::FETCH_ASSOC);
$question_count = count($questions);

//get teams
$state = $db->prepare("select * from teams where deleted = 0");
$state->execute();
$teams = $state->fetchAll(PDO::FETCH_ASSOC);


$divisor = 4;
$base_score = $question_count * (4 / $divisor);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Quiz Statistics</title>


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
                            <li><a href="quiz.php?id=<? echo $quiz['id']; ?>"><? echo $quiz['quiz_name']; ?></a></li>
                            <li class="active">Statistics</li>
                        </ol>

                        <h1 class="pull-left" style="margin-top:0;">
                            <? echo $quiz['quiz_name']; ?>  Statistics
                        </h1>
                    </div>
                </div>

                <!-- PAGE CONTENT HERE -->

                <div class="row">
                    <div class="col-md-12">
                        <p>
                            Info:
                        </p>
                        <ul>
                            <li>Number Questions: <? echo $question_count; ?></li>
                            <li>Total Points: <? echo $base_score; ?></li>
                        </ul>


                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Team Name</th>
                                    <th>Questions Correct</th>
                                    <th>Questions Incorrect</th>
                                    <th>Total Points</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?
                                    $correctState = $db->prepare("select * from quiz_answers qa inner join quiz_questions qq on qq.id = qa.quiz_question_id where qq.quiz_id = ? and team_id = ? and status = 1");
                                    $incorrectState = $db->prepare("select * from quiz_answers qa inner join quiz_questions qq on qq.id = qa.quiz_question_id where qq.quiz_id = ? and team_id = ? and status = -1");
                                    foreach ($teams as $team) {
                                        $correctState->execute(array($quiz['id'], $team['id']));
                                        $correct = $correctState->fetchAll(PDO::FETCH_ASSOC);
                                        $correct_count = count($correct);
                                        $incorrectState->execute(array($quiz['id'], $team['id']));
                                        $incorrect = $incorrectState->fetchAll(PDO::FETCH_ASSOC);
                                        $incorrect_count = count($incorrect);
                                        ?>
                                            <tr>
                                                <td><? echo $team['team_name']; ?></td>
                                                <td><? echo $correct_count; ?> (-<? echo $correct_count * (4 / $divisor) ?>)</td>
                                                <td><? echo $incorrect_count; ?> (+<? echo $incorrect_count / $divisor ?>)</td>
                                                <td><? echo $base_score - ($correct_count * (4 / $divisor)) + ($incorrect_count / $divisor); ?></td>
                                            </tr>
                                        <?
                                    }
                                ?>
                            </tbody>
                        </table>
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