<?php
require_once "../content/require.php";

if (!isUserLoggedIn()) {
    header("Location: ../account/login.php");
}

$state = $db->prepare("select * from competition_sections where start <= ? and `end` >= ?");
$state->execute(array(time(), time()));
$sections = $state->fetchAll(PDO::FETCH_ASSOC);
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
                        <h1 class="text-center">Quiz</h1>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <? if (count($sections) > 0) {
                            //present quiz options
                            $state = $db->prepare("select *, q.id as 'quiz_id' from section_quizzes sq  INNER JOIN quizzes q ON q.id = sq.quiz_id where sq.section_id = ? and sq.removed = false");
                            $quiz_count = 0;
                            foreach ($sections as $section) {
                                $state->execute(array($section['id']));
                                $quizzes = $state->fetchAll(PDO::FETCH_ASSOC);

                                if (count($quizzes) > 0) {
                                    ?>
                                    <p>Quizzes Available</p>
                                    <?
                                    foreach ($quizzes as $quiz) {
                                        ?>
                                        <a href="take.php?id=<? echo $quiz['quiz_id']; ?>&section_id=<? echo $quiz['section_id'] ?>"><? echo $quiz['quiz_name'] ?></a>
                                        <?
                                    }
                                    ?>
                                    <hr />
                                    <?
                                    $quiz_count++;
                                }
                            }

                            if ($quiz_count == 0) {
                                ?>
                                <div class="center-block">
                                    <h3 class="text-center">There doesn't appear to be a quiz available!</h3>
                                </div>
                                <?
                            }
                        } else {
                            ?>
                            <div class="center-block">
                                <h3 class="text-center">There doesn't appear to be a quiz right now!</h3>
                            </div>
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


    <script src="../js/liveEvents.js"></script>
</body>
</html>