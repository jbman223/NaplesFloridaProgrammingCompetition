<?php
require_once "../../content/require.php";

if (!isUserLoggedIn()) {
    die();
}
if (!$user['admin']) {
    die();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Create New Competition</title>


    <link rel="stylesheet" href="../../../css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/site.css">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">

    <script src="http://programmingcompetition.org/compete/jquery.min.js"></script>
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
                            <li><a href="index.php">Competition Manager</a></li>
                            <li class="active">New Competition</li>
                        </ol>

                        <h1 class="text-center">
                            <? echo !isset($_GET['id'])?"Create New":"Edit"; ?> Competition
                        </h1>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <form class="form-horizontal create">
                            <fieldset>
                                <!-- Text input-->
                                <div class="form-group">
                                    <label class="col-md-2 control-label" for="competition_name">Competition Name</label>

                                    <div class="col-md-10">
                                        <input id="competition_name" name="competition_name" placeholder="Name"
                                               class="form-control input-md" type="text">

                                    </div>
                                </div>

                                <!-- Textarea -->
                                <div class="form-group">
                                    <label class="col-md-2 control-label" for="competition_description">Competition
                                        Description</label>

                                    <div class="col-md-10">
                            <textarea class="form-control" id="competition_description"
                                      name="competition_description"></textarea>
                                    </div>
                                </div>

                                <?

                                if (isset($_GET['id'])) {
                                    ?>
                                    <input name="competition_id" type="hidden" value="<? echo $_GET['id']; ?>" />
                                    <?
                                }

                                ?>

                                <!-- Button -->
                                <div class="form-group">
                                    <label class="col-md-2 control-label" for="submit"></label>

                                    <div class="col-md-4">
                                        <button id="submit" name="submit" class="btn btn-primary"><? echo !isset($_GET['id'])?"Create New":"Save"; ?>
                                        </button>

                                        <? if (isset($_GET['id'])) {
                                            ?>
                                            <a href="competition.php?id=<? echo $_GET['id']; ?>" class="btn btn-danger">Cancel</a>
                                            <?
                                        } ?>
                                    </div>
                                </div>


                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>


    </div>

    <script src="../../js/newCompetition.js"></script>
</body>
</html>
