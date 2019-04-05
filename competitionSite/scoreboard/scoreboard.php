<?php
require_once "../assets/require.php";
if (!isLoggedIn()) {
    header("Location: login.php");
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
    <link rel="icon" href="../../favicon.ico">

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

    <div class="row">
        <div class="col-md-12">
            <h3 class="info-text text-center">Loading scoreboard.</h3>
            <table class="table scoreboard" style="display: none;">

            </table>
        </div>
    </div>
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

            if (data.time_remaining < 60) {
                setTimeout(function () {
                    competition()
                }, 1000);
            } else {
                setTimeout(function () {
                    competition()
                }, 4 * 1000);
            }

        }, "json");
    }

    function loadScoreboard() {
        $.get("api/fetch.php", function (data) {
            data = jQuery.parseJSON(data);
            console.log(data);
            if (data.error) {
                $(".info-text").text("Not currently in a competition, no scoreboard loaded.");
            } else {
                var scoreboard = $(".scoreboard");
                var header = "";
                console.log(data.team_ids);
                scoreboard.html("");
                header += ("<tr><th>Team Name</th>");
                data.problem_names.forEach(function (problemName) {
                    header += ("<th>"+problemName+"</th>")
                });
                header += ("<th>Total Points</th></tr>");
                scoreboard.append(header);
                $(".info-text").hide();
                scoreboard.show();

                for (var i = 0; i < data.team_ids.length; i++) {
                    var team = data[data.team_ids[i]];
                    var thisRow = "";
                    thisRow += ("<tr>");
                    thisRow += ("<td>"+team['team_name']+"</td>");
                    $.each(team['problems'], function (index, value) {
                        if (value['solved']) {
                            thisRow += ("<td class='success'><span class='glyphicon glyphicon-ok'></span> <span class='small'>"+value['points']+" points</span></td>");
                        } else {
                            thisRow += ("<td><span class='glyphicon glyphicon-remove'></span> <span class='small'>"+value['points']+" points</span></td>");
                        }
                    });
                    thisRow += ("<td>"+team['total_points']+"</td>");
                    thisRow += ("</tr>");
                    scoreboard.append(thisRow);
                }
            }
        }, "json")
    }

    function loadAlerts() {
        $.get("../assets/alerts.php", function (data) {
            console.log(data);
            if (data.error) {
                $(".alert-special").fadeOut("slow");
            } else {
                $(".alert-special").text(data['message']).show();
            }
            setTimeout(function () { loadAlerts(); }, 1000*5);
        }, "json");
    }

    $(function () {
        loadServerTime();
        competition();
        loadScoreboard();
        loadAlerts();
    });

</script>
</body>
</html>