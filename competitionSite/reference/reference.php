<?php
require_once "../assets/require.php";

if (!isLoggedIn()) {
    header("Location: ../../index.php");
    die();
}

//get current competition id
$state = $db->prepare("SELECT field_value FROM admin_current_competition ");
$state->execute();
$fInfo = $state->fetchAll(PDO::FETCH_NUM);

$inComp = filter_var($fInfo[1][0], FILTER_VALIDATE_BOOLEAN);
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
        <div class="col-md-4 col-sm-4 col-xs-4"><h3>Welcome to the
                competition, <? echo teamName($_SESSION['team_id']); ?>.</h3>
        </div>
        <div class="col-md-3 col-sm-4 col-xs-4"><p>Server Time: <span class="time">Fetching...</span><br>
                <span class="current_competition">Fetching...</span><br>
            </p></div>
        <div class="col-md-3 col-sm-2 col-xs-2">

        </div>
        <div class="col-md-1 col-sm-1 col-xs-1"><p class="text-center"><a href="../index.php"><span
                        class="glyphicon glyphicon-home icon-font" aria-hidden="true"></span><br><span class="small">HOME</span></a>
            </p></div>
        <div class="col-md-1 col-sm-1 col-xs-1"><p class="text-center"><a href="../assets/logout.php"><span
                        class="glyphicon glyphicon-log-out icon-font" aria-hidden="true"></span><br><span class="small">LOG OUT</span></a>
            </p></div>
    </div>

    <div class="alert alert-info alert-special" style="display: none;"></div>

    <ul class="lead">
            <li><a href="http://docs.oracle.com/javase/7/docs/api/" target="_blank">Java 7</a></li>
            <li><a href="http://docs.oracle.com/javase/8/docs/api/" target="_blank">Java 8</a></li>
            <li><a href="http://www.open-std.org/jtc1/sc22/wg14/www/docs/n1256.pdf" target="_blank">C</a></li>
            <li><a href="https://docs.python.org/3/reference/index.html" target="_blank">Python</a></li>
            <li><a href="https://msdn.microsoft.com/en-us/library/3bstk3k5.aspx" target="_blank">C++</a></li>
        </ul>
</div>

<div class="modal fade lock">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <p>Eyes to the front please!</p>
            </div>
        </div>
    </div>
</div>

<script src="http://programmingcompetition.org/competitionSite/jquery.min.js"></script>
<script src="/js/bootstrap.min.js"></script>
<script>
    var focus = false;
    function competition() {
        $.get("../assets/competitionInfo.php", function (data) {
            var info = $(".current_competition");
            info.text("");
            if (data.in_competition) {
                info.append("Competition: " + data.competition_name + "<br>");
                info.append("Time Remaining: " + data.time_remaining_human + "<br>");
            } else {
                info.append("Not in a competition currently.");
            }

            if (data.focus_mode) {
                focus = true;
                $(".lock").modal({show: true});
            } else {
                focus = false;
                $(".lock").modal('hide');
            }

            setTimeout(function () {
                competition()
            }, 4 * 1000);

        }, "json");
    }

    function loadAlerts() {
        $.get("../assets/alerts.php", function (data) {
            console.log(data);
            if (data.error) {
                $(".alert-special").fadeOut("slow");
            } else {
                $(".alert-special").text(data['message']).fadeIn("slow");
            }
            setTimeout(function () { loadAlerts(); }, 1000*5);
        }, "json");
    }

    $(".lock").on('hide.bs.modal', function (e) {
        if (focus) {
            e.preventDefault();
        }
    });

    function loadServerTime() {
        $.get("../assets/serverTime.php", function (data) {
            $(".time").text(data);
            setTimeout(function () {
                loadServerTime()
            }, 500);
        });
    }

    $(function () {
        loadServerTime();
        competition();
        loadAlerts();
    });
</script>
</body>
</html>