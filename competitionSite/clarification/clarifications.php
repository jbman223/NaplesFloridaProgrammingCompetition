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
        <div class="col-md-4">
            <div class="alert alert-danger text-center" role="alert" style="display: none;"></div>
            <div class="alert alert-info text-center form-alert" role="alert" style="display: none;">Creating clarification,
                please wait a second.
            </div>
            <div class="alert alert-success text-center" role="alert" style="display: none;">Your clarification has been created!
            </div>
            <h5>Request A Clarification</h5>

            <form class="form-horizontal clarification">
                <fieldset>

                    <!-- Text input-->
                    <div class="form-group">
                        <label class="col-md-2 control-label" for="title">Title</label>
                        <div class="col-md-10">
                            <input id="title" name="title" placeholder="Title" class="form-control input-md" type="text">
                        </div>
                    </div>

                    <!-- Textarea -->
                    <div class="form-group">
                        <label class="col-md-2 control-label" for="message">Message</label>

                        <div class="col-md-10">
                            <textarea class="form-control" id="message" name="message"></textarea>
                        </div>
                    </div>

                    <!-- Select Basic -->
                    <div class="form-group">
                        <label class="col-md-2 control-label" for="subject">Subject</label>

                        <div class="col-md-10">
                            <select id="subject" name="subject" class="form-control">
                                <option value="question">Question Clarification</option>
                                <option value="computer">Computer Error</option>
                                <option value="site error">Site Error</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-2 control-label" for="problem">Problem</label>

                        <div class="col-md-10">
                            <select id="problem" name="problem" class="form-control">
                                <option value="No Specific Problem">None</option>
                                <?
                                $state = $db->prepare("SELECT field_value FROM admin_current_competition ");
                                $state->execute();
                                $fInfo = $state->fetchAll(PDO::FETCH_NUM);

                                $state = $db->prepare("SELECT * FROM problems WHERE competition_id = ?");
                                $state->execute(array(intval($fInfo[3][0])));
                                $problems = $state->fetchAll();

                                foreach ($problems as $problem) {
                                        ?>
                                        <option
                                            value="<? echo $problem['problem_title']; ?>"><? echo $problem['problem_title']; ?></option>
                                    <?
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label" for="singlebutton"></label>

                        <div class="col-md-4">
                            <button id="singlebutton" name="singlebutton" class="btn btn-primary">Submit</button>
                        </div>
                    </div>

                </fieldset>
            </form>
        </div>

        <div class="col-md-8">
            <table class="table threads">
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
            setTimeout(function () { loadServerTime() }, 500);
        });
    }

    $(".lock").on('hide.bs.modal', function (e) {
        if (focus) {
            e.preventDefault();
        }
    });

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

    function updateTable() {
        $.get("api/currentList.php", function (data) {
            console.log(data);
            var toAppend = "";
            toAppend += "<tr><th>Number Of Replies</th><th>Problem Title</th><th>Title</th></tr>";
            for (var i = 0; i < data.length; i++) {
                toAppend += "<tr>";
                toAppend += "<td>"+data[i].replies+"</td>";
                toAppend += "<td>"+data[i].title+"</td>";
                toAppend += "<td><a href='thread.php?id="+data[i].id+"'>"+data[i].subject+"</a></td>";
                toAppend += "</tr>";
            }

            $(".threads").html(toAppend);

            setTimeout(function () {
                updateTable();
            }, 2 * 1000);
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

    $(function () {
        loadServerTime();
        competition();
        updateTable();
        loadAlerts();
    });

    $(".clarification").submit(function (e) {
        e.preventDefault();
        $(".clarification").fadeOut("slow");
        $(".form-alert").show();
        $.post("api/api.php", {type: "create", title: $("input[name=title]").val(), problem: $("select[name=problem]").val(), subject: $("select[name=subject]").val(), message: $("textarea[name=message]").val()}, function (data) {
            if (data.error) {
                $(".form-alert").hide();
                $(".alert-danger").text(data.error).show("slow");
                $(".clarification").fadeIn("slow");
            } else {
                $(".form-alert").hide();
                $(".alert-success").text(data.success).show("slow");
                setTimeout(function () {window.location = "thread.php?id="+data.id}, 1000)
            }
        }, "json")
    });
</script>
</body>
</html>