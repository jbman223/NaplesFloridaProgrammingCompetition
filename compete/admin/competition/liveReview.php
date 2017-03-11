<?php
require_once "../../content/require.php";

if (!isUserLoggedIn()) {
    header("location: ../../account/login.php");
}
if (!$user['admin']) {
    header("location: ../../index.php");
}

if (!isset($_GET['id'])) {
    header("location: competitionList.php");
}

$state = $db->prepare("select * from competitions where id = ?");
$state->execute(array($_GET['id']));

$competition = $state->fetchAll(PDO::FETCH_ASSOC);
if (count($competition) > 0)
    $competition = $competition[0];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Live Review</title>


    <link rel="stylesheet" href="../../../css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/site.css">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.2.0/styles/default.min.css">

    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="../../../js/bootstrap.min.js"></script>

    <script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.2.0/highlight.min.js"></script>

    <script>hljs.initHighlightingOnLoad();</script>

    <script src="http://159.203.168.143:8080/socket.io/socket.io.js"></script>

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
                            <li><a href="competitionList.php">Competition List</a></li>
                            <li>
                                <a href="competition.php?id=<? echo $competition['id']; ?>"><? echo $competition['competition_name']; ?></a>
                            </li>
                            <li class="active">Live Review</li>
                        </ol>

                        <h1 class="text-center">
                            Live Review
                        </h1>
                    </div>
                </div>

                <div class="review-container" data-competitionid="<? echo $competition['id']; ?>">

                </div>
            </div>
        </div>


    </div>

    <script src="../../js/liveReview.js"></script>
    <script src="../../js/liveEvents.js"></script>
</body>
</html>
