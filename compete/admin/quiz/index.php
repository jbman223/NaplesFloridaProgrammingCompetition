<?php
require_once "../../content/require.php";

if (!isUserLoggedIn()) {
    header("Location: account/login.php");
}
if (!$user['admin']) {
    header("Location: /account/login.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Quiz Administration Center</title>


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
                            <li class="active">Quiz Center</li>
                        </ol>

                        <h1 class="text-center">
                            Quiz Center
                        </h1>
                    </div>
                </div>


                <div class="row">
                    <div class="col-md-3">
                        <a href="newQuiz.php"><h2><span class="glyphicon glyphicon-plus-sign"></span> Create Quiz</h2></a>
                    </div>
                    <div class="col-md-3">
                        <a href="quizList.php"><h2><span class="glyphicon glyphicon-list"></span> Quiz List</h2></a>
                    </div>
                </div>

            </div>
        </div>


    </div>
</body>
</html>