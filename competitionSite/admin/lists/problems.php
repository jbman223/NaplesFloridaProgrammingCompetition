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
                <span class="current_competition">Fetching...</span><br>
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
            <table class="table table-hover">
                <tr>
                    <th>Problem Title</th>
                    <th>Problem Link</th>
                    <th>Competition ID</th>
                    <th>Delete Problem</th>
                </tr>
                <?
                $state = $db->prepare("SELECT * FROM problems ORDER BY competition_id");
                $state->execute();
                $problems = $state->fetchAll();

                foreach ($problems as $problem) {
                    ?>
                    <tr data-problem-id="<? echo $problem['id']; ?>">
                        <td><? echo $problem['problem_title']; ?></td>
                        <td><a href="../../assets/problem.php?id=<? echo $problem['id']; ?>">View</a></td>
                        <td><? echo $problem['competition_id']; ?></td>
                        <td><a href="#" class="btn btn-danger btn-sm delete">Delete</a></td>
                    </tr>
                <?
                }
                ?>
            </table>
        </div>
    </div>
</div>

<script src="http://programmingcompetition.org/competitionSite/jquery.min.js"></script>
<script src="/js/bootstrap.min.js"></script>
<script>
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

    function loadServerTime() {
        $.get("../../assets/serverTime.php", function (data) {
            $(".time").text(data);
            setTimeout(loadServerTime(), 500);
        });
    }

    $(function () {
        loadServerTime();
        competition();
    });

    $(".delete").click(function (e) {
        e.preventDefault();
        var id = $(this).parent().parent().data("problem-id");
        if ($(this).parent().parent().hasClass("danger")) {
            console.log("attempting to unmark for deletion. ID: "+id);
            $.post("../../assets/api.php", {id: id, type: "delete_problem", toDelete: 0}, function (data) {
                if (data.success)
                    window.location.reload();
            }, "json");
        } else {
            console.log("attempting to mark for deletion. ID: "+id);
            $.post("../../assets/api.php", {id: id, type: "delete_problem", toDelete: 1}, function (data) {
                if (data.success)
                    window.location.reload();
            }, "json");
        }
    });
</script>
</body>
</html>