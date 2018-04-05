<?php
require_once "../../content/require.php";

if (!isUserLoggedIn()) {
    header("Location: /compete/account/login.php");
}
if (!$user['admin']) {
    header("Location: /compete/account/login.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Quiz List</title>


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
                            <li class="active">Quiz List</li>
                        </ol>

                        <h1 class="text-center">
                            Quiz Listing
                        </h1>
                    </div>
                </div>

                <table class="table table-bordered table-responsive table-striped">
                    <thead>
                    <tr>
                        <th>Quiz</th>
                        <th>Remove Quiz</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?
                    $state = $db->prepare("select * from quizzes where removed = false");
                    $state->execute();

                    $problems = $state->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($problems as $problem) {
                        ?>
                        <tr>
                            <td><a href="quiz.php?id=<? echo $problem["id"]; ?>"><? echo $problem["quiz_name"]!=""?$problem["quiz_name"]:"Unnamed"; ?></a></td>
                            <td><a href="removeQuiz.php?id=<? echo $problem["id"]; ?>" class="btn btn-danger btn-sm">Remove</a></td>
                        </tr>
                        <?
                    }
                    ?>
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</body>
</html>