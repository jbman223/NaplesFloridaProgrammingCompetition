<?php
require_once "../../content/require.php";

if (!isUserLoggedIn()) {
    header("Location: account/login.php");
}
if (!$user['admin']) {
    header("Location: /account/login.php");
}

if (!isset($_GET['id'])) {
    header("Location: quizList.php");
    die();
}


$state = $db->prepare("SELECT * FROM quizzes where id = ?");
$state->execute(array($_GET['id']));
$quiz = $state->fetchAll(PDO::FETCH_ASSOC);
if (count($quiz) == 1) {
    $quiz = $quiz[0];
} else {
    header("Location: quizList.php");
    die();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Create Question</title>


    <link rel="stylesheet" href="../../../css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/site.css">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">

    <script src="/compete/jquery.min.js"></script>
    <script src="../../../js/bootstrap.min.js"></script>

    <? echo $gaCode; ?>
</head>

<body>

<div class="container-fluid">

    <? require_once "../../content/menu.php"; ?>

    <div class="bg-container">
        <div class="row">
            <div class="container">

                <!-- PAGE CONTENT HERE -->
                <div class="row">
                    <div class="col-md-12">
                        <ol class="breadcrumb">
                            <li><a href="../">Administration</a></li>
                            <li><a href="index.php">Quiz Center</a></li>
                            <li><a href="quizList.php">Quiz List</a></li>
                            <li><a href="quiz.php?id=<? echo $_GET['id']; ?>"><? echo $quiz['quiz_name'] ?></a></li>
                            <li class="active">New Quiz</li>
                        </ol>

                        <h1 class="text-center">
                            <? echo isset($_GET['id'])?"Create New":"Edit"; ?> Question
                        </h1>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <form class="form-horizontal create">
                            <fieldset>
                                <!-- Text input-->
                                <div class="form-group">
                                    <label class="col-md-2 control-label" for="author">Question Author</label>

                                    <div class="col-md-10">
                                        <input id="author" name="author" placeholder="Author"
                                               class="form-control input-md" type="text">

                                    </div>
                                </div>


                                <div class="form-group">
                                    <label class="col-md-2 control-label" for="picture">Question Picture URL</label>

                                    <div class="col-md-10">
                                        <input id="picture" name="picture" placeholder="Picture URL"
                                               class="form-control input-md" type="text">

                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-2 control-label" for="answer">Question Answer</label>

                                    <div class="col-md-10">
                                        <input id="answer" name="answer" placeholder="Answer"
                                               class="form-control input-md" type="text">

                                    </div>
                                </div>



                                <?

                                if (isset($_GET['question_id'])) {
                                    ?>
                                    <input name="question_id" type="hidden" value="<? echo $_GET['question_id']; ?>" />
                                    <?
                                }

                                if (isset($_GET['id'])) {
                                    ?>
                                    <input name="quiz_id" type="hidden" value="<? echo $_GET['id']; ?>" />
                                    <?
                                }

                                ?>

                                <!-- Button -->
                                <div class="form-group">
                                    <label class="col-md-2 control-label" for="submit"></label>

                                    <div class="col-md-4">
                                        <button id="submit" name="submit" class="btn btn-primary">Save Question</button>
                                    </div>
                                </div>


                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>


    </div>

    <script src="../../js/newQuestion.js"></script>
</body>
</html>