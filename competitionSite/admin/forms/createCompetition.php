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
    <link rel="icon" href="../../../../favicon.ico">

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
                <span class="current_competition">Fetching...</span><br>
            </p></div>
        <div class="col-md-3">

        </div>
        <div class="col-md-1"><p class="text-center"><a href="../index.php"><span
                        class="glyphicon glyphicon-home icon-font" aria-hidden="true"></span><br><span class="small">HOME</span></a>
            </p></div>
        <div class="col-md-1"><p class="text-center"><a href="../assets/logout.php"><span
                        class="glyphicon glyphicon-log-out icon-font" aria-hidden="true"></span><br><span class="small">LOG OUT</span></a>
            </p></div>
    </div>

    <div class="row">
        <div class="col-lg-4 col-md-4 text-center">
            <div class="center-block">
                <p class="lead text-justify">
                    Create a new competition. Enter the competition time, and the start and end times. for the
                    competition. Start and end dates should be typed in plain english, almost any format will work.
                    Examples: &quot;March 12 2015 8:45am&quot;
                </p>
            </div>
        </div>
        <div class="col-lg-8 col-md-8">
            <div class="alert alert-danger text-center" role="alert" style="display: none;"></div>
            <div class="alert alert-info text-center" role="alert" style="display: none;">Creating competition,
                please wait a second.
            </div>
            <div class="alert alert-success text-center" role="alert" style="display: none;">Your team has been created.
                You can now add members.
            </div>
            <form class="form-horizontal create">
                <fieldset>
                    <!-- Text input-->
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="competition_name">Competition Name</label>

                        <div class="col-md-5">
                            <input id="competition_name" name="competition_name" placeholder="Competition Name"
                                   class="form-control input-md" type="text">

                        </div>
                    </div>

                    <!-- Text input-->
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="start_time">Start Time</label>

                        <div class="col-md-5">
                            <input id="start_time" name="start_time" placeholder="March 28 2015 8:30am"
                                   class="form-control input-md" required="" type="text">

                        </div>
                    </div>

                    <!-- Text input-->
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="end_time">End Time</label>

                        <div class="col-md-5">
                            <input id="end_time" name="end_time" placeholder="March 28 1:30pm"
                                   class="form-control input-md" required="" type="text">

                        </div>
                    </div>

                    <!-- Multiple Radios -->
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="graded">Graded</label>

                        <div class="col-md-4">
                            <div class="radio">
                                <label for="graded-0">
                                    <input name="graded" id="graded-0" value="1" checked="checked" type="radio">
                                    Yes
                                </label>
                            </div>
                            <div class="radio">
                                <label for="graded-1">
                                    <input name="graded" id="graded-1" value="0" type="radio">
                                    No
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Button -->
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="create"></label>

                        <div class="col-md-4">
                            <button id="create" name="create" class="btn btn-success">Create</button>
                        </div>
                    </div>

                </fieldset>
            </form>


        </div>
    </div>
</div>

<script src="http://programmingcompetition.org/competitionSite/jquery.min.js"></script>
<script src="/js/bootstrap.min.js"></script>
<script>
    function loadServerTime() {
        $.get("../../assets/serverTime.php", function (data) {
            $(".time").text(data);
            setTimeout(loadServerTime(), 500);
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
            setTimeout(function() {competition()}, 4*1000);

        }, "json");
    }

    $(function () {
        loadServerTime();
        competition();
    });

    $(".create").submit(function (e) {
        e.preventDefault();
        var graded = $("input[name=graded]").val();
        var name = $("input[name=competition_name]").val();
        var start = $("input[name=start_time]").val();
        var end = $("input[name=end_time]").val();
        $(".create").hide("fast");
        $(".alert-danger").hide("fast");
        $(".alert-info").show("fast");
        $(".alert-success").hide("fast");
        $.post("../../assets/api.php", {type: "create_competition", graded: graded, competition_name: name, start_time: start, end_time: end}, function (e) {
            console.log(e);
            $(".alert-info").hide();
            if (e.error) {
                $(".alert-danger").text(e.error).show("slow");
                $(".create").show("fast");
            } else if (e.success) {
                $(".alert-success").text(e.success).show("fast");
                setTimeout(function () {
                    window.location = "../index.php";
                }, 1000);
            }
        }, "json");
    });
</script>
</body>
</html>