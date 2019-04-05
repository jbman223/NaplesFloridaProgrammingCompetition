<?php
require_once "../../assets/require.php";

if (!isAdmin()) {
    header("Location: ../../index.php");
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
        <div class="col-md-4"><h3>Welcome to the competition admin, <? echo teamName($_SESSION['team_id']); ?>.</h3>
        </div>
        <div class="col-md-3"><p>Server Time: <span class="time">Fetching...</span><br>
                <span class="current_competition">Fetching Current Competition...</span><br>
            </p></div>
        <div class="col-md-3">

        </div>
        <div class="col-md-1"><p class="text-center"><a href="../index.php"><span
                        class="glyphicon glyphicon-home icon-font" aria-hidden="true"></span><br><span class="small">HOME</span></a>
            </p></div>
        <div class="col-md-1"><p class="text-center"><a href="../../assets/logout.php"><span
                        class="glyphicon glyphicon-log-out icon-font" aria-hidden="true"></span><br><span class="small">LOG OUT</span></a>
            </p></div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <pre><span class="info">

                </span>Refreshing in <span class="refresh_timeout"></span> seconds.
            </pre>
        </div>
    </div>
</div>

<script src="http://programmingcompetition.org/competitionSite/jquery.min.js"></script>
<script src="/js/bootstrap.min.js"></script>
<script>
    var timeToNext = 60;
    var focus = false;

    function loadServerTime() {
        $.get("../../assets/serverTime.php", function (data) {
            $(".time").text(data);
            setTimeout(function () {loadServerTime()}, 500);
        });
    }

    function competition() {
        $.get("../../assets/competitionInfo.php", function (data) {
            var info = $(".current_competition");
            info.text("");
            if (data.in_competition) {
                info.append("Competition: "+data.competition_name+"<br>");
                info.append("Time Remaining: "+data.time_remaining_human+"<br>");
            } else {
                info.append("Not in a competition currently.");
            }

            if (data.focus_mode) {
                focus = "true";
                console.log("Focus Mode");
            }

            setTimeout(function() {competition()}, 4*1000);

        }, "json");
    }

    function currentCompetitionInformation() {
        $.get("../../assets/competitionInfo.php", function (data) {
            var info = $(".info");
            info.text("");
            info.append("In Competition: "+data.in_competition+"<br>");
            info.append("Server Time: "+data.server_time_human+"<br>");
            if (data.in_competition) {
                info.append("Competition Name: "+data.competition_name+"<br>");
                info.append("End Time: "+data.competition_end_time_human+"<br>");
                info.append("Time Remaining: "+data.time_remaining_human+"<br>");

            }
            info.append("Focus Mode: "+data.focus_mode+"<br>");

            info.append("Last Update: "+data.last_update+" ago.<br>");
            timeToNext = 10;
            updateRefresh();
            setTimeout(function() {currentCompetitionInformation()}, 10*1000);

        }, "json");
    }

    function updateRefresh() {
        console.log(timeToNext);
        timeToNext = timeToNext - 1;
        $(".refresh_timeout").text(timeToNext);
        if (timeToNext > 0) {
            setTimeout(function() {updateRefresh()}, 1000);
        }
    }

    $(function () {
        loadServerTime();
        currentCompetitionInformation();
        competition();
    });


</script>
</body>
</html>