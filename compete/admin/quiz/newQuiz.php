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

    <title>Create New Quiz</title>


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
                            <li class="active">New Quiz</li>
                        </ol>

                        <h1 class="text-center">
                            <? echo isset($_GET['id'])?"Create New":"Edit"; ?> Quiz
                        </h1>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <form class="form-horizontal create">
                            <fieldset>
                                <!-- Text input-->
                                <div class="form-group">
                                    <label class="col-md-2 control-label" for="problem_name">Quiz Name</label>

                                    <div class="col-md-10">
                                        <input id="quiz_name" name="quiz_name" placeholder="Name"
                                               class="form-control input-md" type="text">

                                    </div>
                                </div>



                                <?

                                if (isset($_GET['id'])) {
                                    ?>
                                    <input name="id" type="hidden" value="<? echo $_GET['id']; ?>" />
                                    <?
                                }

                                ?>

                                <!-- Button -->
                                <div class="form-group">
                                    <label class="col-md-2 control-label" for="submit"></label>

                                    <div class="col-md-4">
                                        <button id="submit" name="submit" class="btn btn-primary">Create Quiz
                                        </button>
                                    </div>
                                </div>


                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>


    </div>

    <script src="../../js/newQuiz.js"></script>
</body>
</html>