<?php
require_once "../../assets/require.php";

if (!isAdmin()) {
    header("Location: ../../index.php");
    die();
}

if (isset($_SESSION['error_message'])) {
    $error = $_SESSION['error_message'];
    unset($_SESSION['error_message']);
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
            <? if (isset($error)) { ?>
            <div class="alert alert-danger text-center" role="alert"><? echo $error; ?></div>
            <? } ?>
            <div class="alert alert-info text-center" role="alert" style="display: none;">Creating competition,
                please wait a second.
            </div>
            <div class="alert alert-success text-center" role="alert" style="display: none;">Your team has been created.
                You can now add members.
            </div>
            <form class="form-horizontal create" enctype="multipart/form-data" action="../../assets/api.php" method="POST">
                <fieldset>
                    <!-- Text input-->
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="competition_name">Problem Title</label>

                        <div class="col-md-5">
                            <input id="competition_name" name="problem_title" placeholder="Problem Title"
                                   class="form-control input-md" type="text">

                        </div>
                    </div>

                    <!-- Text input-->
                    <div class="form-group">
                        <label for="file" class="col-md-4 control-label">Upload Problem</label>

                        <div class="col-md-5">
                            <input type="hidden" name="MAX_FILE_SIZE" value="40000000"/>
                            <input type="file" id="file" name="file" accept=".zip">
                            <input type="hidden" name="type" value="upload_problem">

                            <p class="help-block">Choose the .zip which contains the proper files.</p>
                        </div>
                    </div>

                    <!-- Select Basic -->
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="competition_id">Competition</label>

                        <div class="col-md-5">
                            <select id="competition_id" name="competition_id" class="form-control">
                                <?
                                $state = $db->prepare("SELECT * FROM admin_scheduled_competitions");
                                $state->execute();
                                $competitions = $state->fetchAll();

                                if (count($competitions) == 0) {
                                    ?>
                                    <option value="-1">No Competitions</option>
                                    <?
                                }

                                foreach ($competitions as $comp) {
                                    ?>
                                    <option value="<? echo $comp['id'] ?>"><? echo $comp['competition_name'] ?></option>
                                <?
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <!-- Button -->
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="create"></label>

                        <div class="col-md-4">
                            <button id="create" name="create" class="btn btn-success">Upload</button>
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
</script>
</body>
</html>