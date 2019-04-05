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
                    Toggle focus mode on the competitiors computers. This will lock them from accessing the website.
                </p>
            </div>
        </div>
        <div class="col-lg-8 col-md-8">
            <div class="alert alert-danger text-center" role="alert" style="display: none;"></div>
            <div class="alert alert-info text-center" role="alert" style="display: none;">Creating alert,
                please wait a second.
            </div>
            <div class="alert alert-success text-center" role="alert" style="display: none;">Your alert has been created.
            </div>
            <form class="form-horizontal create">
                <fieldset>
                    <!-- Button -->
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="create"></label>

                        <div class="col-md-4">
                            <button id="create" name="create" class="btn btn-success">Toggle Focus Mode</button>
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
        var alert = $("input[name=alert_text]").val();
        $(".create").hide("fast");
        $(".alert-danger").hide("fast");
        $(".alert-info").show("fast");
        $(".alert-success").hide("fast");
        $.post("../../assets/api.php", {type: "toggle_focus", alert_text: alert}, function (e) {
            console.log(e);
            $(".alert-info").hide();
            if (e.error) {
                $(".alert-danger").text(e.error).show("slow");
                $(".create").show("fast");
            } else if (e.success) {
                $(".alert-success").text(e.success).show("fast");
                setTimeout(function () {
                    window.location = "../index.php";
                }, 1200);
            }
        }, "json");
    });
</script>
</body>
</html>