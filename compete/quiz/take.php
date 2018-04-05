<?php
require_once "../content/require.php";

if (!isUserLoggedIn()) {
    header("Location: ../account/login.php");
}

if (!isset($_GET['id'], $_GET['section_id'])) {
    header("location: index.php");
    die();
}

$state = $db->prepare("select * from competition_sections where start <= ? and `end` >= ? and id = ?");
$state->execute(array(time(), time(), $_GET['section_id']));
$sections = $state->fetchAll(PDO::FETCH_ASSOC);

if (count($sections) == 1) $sections = $sections[0];
else {
    header("location: index.php");
    die();
}

$state = $db->prepare("select * from section_quizzes sq inner join quizzes q on q.id = sq.quiz_id where sq.quiz_id = ? and sq.section_id = ? and sq.removed = false");
$state->execute(array($_GET['id'], $_GET['section_id']));
$quiz = $state->fetchAll(PDO::FETCH_ASSOC);

if (count($quiz) == 1) {
    $quiz = $quiz[0];
} else {
    header("location: index.php");
    die();
}

$state = $db->prepare("select count(*) from quiz_questions where quiz_id = ? and removed = false");
$state->execute(array($quiz['quiz_id']));
$quiz_question_count = $state->fetchAll()[0][0];

$state = $db->prepare("select * from quiz_questions where id not in (select quiz_question_id from quiz_answers qa inner join quiz_questions qq on qa.quiz_question_id = qq.id where qa.team_id = ? and (qa.status = 1 or qa.status = -1) and qq.quiz_id = ?) and quiz_id = ? and removed = false order by RAND()");
$state->execute(array($_SESSION['competition_site_id'], $quiz['quiz_id'], $quiz['quiz_id']));
$questions_remaining = $state->fetchAll(PDO::FETCH_ASSOC);


$question = null;
if (count($questions_remaining) > 0) $question = $questions_remaining[0];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Quiz</title>


    <link rel="stylesheet" href="../../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/site.css">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">

    <script src="/compete/jquery.min.js"></script>
    <script src="../../js/bootstrap.min.js"></script>

    <script src="http://ws.programmingcompetition.org:8080/socket.io/socket.io.js"></script>

    <style>
        .answer-radios {
            display: inline-block;
        }

        .answer-radios div {
            display: inline-block;
            margin-right: 10px;
        }

        .answer-radios label {
            font-weight: bold;
            font-size: 18px;
        }

        h4 {
            display: inline-block;
            margin-right: 10px;
        }
    </style>

    <? echo $gaCode; ?>
</head>

<body>

<div class="container-fluid">

    <? require_once "../content/menu.php"; ?>

    <div class="bg-container">
        <div class="row">
            <div class="container">

                <!-- PAGE CONTENT HERE -->
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="text-center">Take <? echo $quiz['quiz_name'] ?></h1>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3">
                        <h3>Stats:</h3>
                        <p>This quiz has <b><? echo $quiz_question_count ?> questions</b>.</p>
                        <p>You have <b><? echo count($questions_remaining); ?> questions remaining.</b></p>

                    </div>
                    <div class="col-md-9">
                        <?
                        if (count($questions_remaining) == 0) {
                            ?>
                            <h3>You've finished this quiz!</h3>
                            <?
                        } else {
                            ?>
                            <h3>Question:</h3>
                            <p>
                                <i>This question came from <? echo $question['author']; ?></i>
                            </p>
                            <img src="<? echo $question['picture']; ?>" style="max-width: 100%;">
                            <form class="quiz-answer" action="answer.php" method="post">
                                <div class="alert alert-danger" style="display: none;">
                                    Please choose an answer!
                                </div>

                                <h4>Your answer:</h4>
                                <div class="answer-radios">
                                    <div class="radio">
                                        <label><input type="radio" name="answer" value="A">A</label>
                                    </div>
                                    <div class="radio">
                                        <label><input type="radio" name="answer" value="B">B</label>
                                    </div>
                                    <div class="radio">
                                        <label><input type="radio" name="answer" value="C">C</label>
                                    </div>
                                    <div class="radio">
                                        <label><input type="radio" name="answer" value="D">D</label>
                                    </div>
                                    <div class="radio">
                                        <label><input type="radio" name="answer" value="E">E</label>
                                    </div>
                                </div>

                                <input type="hidden" name="quiz_id" value="<? echo $quiz['quiz_id']; ?>" />
                                <input type="hidden" name="question_id" value="<? echo $question['id']; ?>" />
                                <input type="hidden" name="section_id" value="<? echo $_GET['section_id']; ?>" />

                                <div>
                                    <button class="btn btn-md btn-danger skip">Skip</button>
                                    <button class="btn btn-md btn-success">Submit Answer</button>
                                </div>
                            </form>
                            <?
                        }
                        ?>
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

    <? require_once "../content/footer.php"; ?>

    <script>
        $(".skip").click(function (e) {
            e.preventDefault();
            $.post("skip.php", {
                quiz_id: $("input[name=quiz_id]").val(),
                question_id: $("input[name=question_id]").val(),
                section_id: $('input[name=section_id').val()
            }, function () {
                window.location.reload();
            });
        });

        $(".quiz-answer").submit(function (e) {
            if ($('input[type=radio]:checked').size() == 0) {
                e.preventDefault();
                $(".alert").show();
            } else {
                $(".alert").hide();
            }
        });
    </script>
    <script src="../js/liveEvents.js"></script>
</body>
</html>