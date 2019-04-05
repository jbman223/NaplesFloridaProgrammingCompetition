<?php
require_once "../assets/require.php";

if (!isAdmin()) {
    header("Location: ../index.php");
    die();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="The official Naples Florida Programming Competition.">
    <meta name="author" content="Jacob Buckheit">
    <link rel="icon" href="../../../favicon.ico">

    <title>NFPC Competition Manager</title>

    <link href="/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="/jb.css" rel="stylesheet">

    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <![endif]-->

    <style>
        .icon-font {
            font-size: 32px;
        }
    </style>
</head>

<body>
<div class="container">
    <div class="row">
        <div class="col-md-4 col-sm-4 col-xs-4"><h3>Welcome to the competition, <? echo teamName($_SESSION['team_id']); ?>.</h3>
        </div>
        <div class="col-md-3 col-sm-4 col-xs-4"><p>Server Time: <span class="time">Fetching...</span><br>
                <span class="current_competition">Fetching...</span><br>
            </p></div>
        <div class="col-md-3 col-sm-2 hidden-xs">

        </div>
        <div class="col-md-1 col-sm-1 col-xs-2"><p class="text-center"><a href="index.php"><span
                        class="glyphicon glyphicon-home icon-font" aria-hidden="true"></span><br><span class="small">HOME</span></a>
            </p></div>
        <div class="col-md-1 col-sm-1 col-xs-2"><p class="text-center"><a href="../assets/logout.php"><span
                        class="glyphicon glyphicon-log-out icon-font" aria-hidden="true"></span><br><span class="small">LOG OUT</span></a>
            </p></div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-body">
                    <p class="text-center">
                        <a href="forms/createCompetition.php">
                            <span class="glyphicon glyphicon-plus-sign" style="font-size: 52px;"></span><br>
                            Create A New Competition
                        </a>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-body">
                    <p class="text-center">
                        <a href="forms/uploadProblem.php">
                            <span class="glyphicon glyphicon-file" style="font-size: 52px;"></span><br>
                            Upload A Problem
                        </a>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-body">
                    <p class="text-center">
                        <a href="scoreboard/scoreboard.php">
                            <span class="glyphicon glyphicon-th-list" style="font-size: 52px;"></span><br>
                            View Scoreboard
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-body">
                    <p class="text-center">
                        <a href="lists/competitions.php">
                            <span class="glyphicon glyphicon-pencil" style="font-size: 52px;"></span><br>
                            Edit Competitions
                        </a>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-body">
                    <p class="text-center">
                        <a href="info/current.php">
                            <span class="glyphicon glyphicon-wrench" style="font-size: 52px;"></span><br>
                            Current Competition Information (DEBUG)
                        </a>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-body">
                    <p class="text-center">
                        <a href="lists/problems.php">
                            <span class="glyphicon glyphicon-th" style="font-size: 52px;"></span><br>
                            Problems
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-body">
                    <p class="text-center">
                        <a href="alerts/alerts.php">
                            <span class="glyphicon glyphicon-info-sign" style="font-size: 52px;"></span><br>
                            Send new alert.
                        </a>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-body">
                    <p class="text-center">
                        <a href="alerts/focus.php">
                            <span class="glyphicon glyphicon-screenshot" style="font-size: 52px;"></span><br>
                            Focus Mode
                        </a>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-body">
                    <p class="text-center">
                        <a href="../clarification/clarifications.php">
                            <span class="glyphicon glyphicon-envelope" style="font-size: 52px;"></span><br>
                            Clarifications
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <h3>EDU Admin Area</h3>
    <div class="row">
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-body">
                    <p class="text-center">
                        <a href="edu/newProblem.php">
                            <span class="glyphicon glyphicon-plus-sign" style="font-size: 52px;"></span><br>
                            Add New EDU Problem
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="http://programmingcompetition.org/competitionSite/jquery.min.js"></script>
<script src="/js/bootstrap.min.js"></script>
<script>
    function loadServerTime() {
        $.get("../assets/serverTime.php", function (data) {
            $(".time").text(data);
            setTimeout(loadServerTime(), 500);
        });
    }

    function competition() {
        $.get("../assets/competitionInfo.php", function (data) {
            var info = $(".current_competition");
            info.text("");
            if (data.in_competition) {
                info.append("Competition: "+data.competition_name+"<br>");
                info.append("Time Remaining: "+data.time_remaining_human+"<br>");
            } else {
                info.append("Not in a competition currently.");
            }
            setTimeout(function() {competition()}, 4*1000);

        }, "json");
    }

    $(function () {
        loadServerTime();
        competition();
    })
</script>
</body>
</html>