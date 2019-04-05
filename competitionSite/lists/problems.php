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

    <div class="row">
        <div class="col-md-5">

            <? if ($inComp) {
                ?>
                <table class="table table-hover">
                    <tr>
                        <th>Problem Title</th>
                        <th>Problem Link</th>
                        <th>Solved</th>
                    </tr>
                    <?
                    $state = $db->prepare("SELECT * FROM problems WHERE competition_id = ?");
                    $state->execute(array(intval($fInfo[3][0])));
                    $problems = $state->fetchAll();

                    $state = $db->prepare("SELECT * FROM solved_problems WHERE team_id = ? AND competition_id = ? AND problem_id = ?");


                    foreach ($problems as $problem) {
                        $state->execute(array($_SESSION['team_id'], $problem['competition_id'], $problem['id']));
                        $solved = $state->fetchAll();
                        ?>
                        <tr data-problem-id="<? echo $problem['id']; ?>"
                            <? if (count($solved) != 0) { ?>class="success"<? } ?>>
                            <td><? echo $problem['problem_title']; ?></td>
                            <td><a href="../assets/problem.php?id=<? echo $problem['id']; ?>">View Problem</a></td>
                            <td>
                                <?

                                if (count($solved) != 0) {
                                    ?>
                                    <span class="glyphicon glyphicon-ok-sign"></span>
                                <?
                                } else {
                                    ?>
                                    <span class="glyphicon glyphicon-remove-sign"></span>
                                <?
                                } ?>
                            </td>
                        </tr>
                    <?
                    }
                    ?>
                </table>
            <?
            } else {
                ?>
                <h5>Not currently in a competition.</h5>
            <?
            } ?>

        </div>
        <div class="col-md-7">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h4 class="text-center">Submit Your Solution</h4>

                    <div class="alert alert-info text-center" role="alert" style="display: none;">Compiling and running
                        code, please
                        wait.
                    </div>
                    <div class="alert alert-success text-center" role="alert" style="display: none;">
                    </div>
                    <div class="alert alert-danger text-center" role="alert" style="display: none;">
                    </div>
                    <form class="form-horizontal problem-submit">
                        <fieldset>
                            <!-- Select Basic -->
                            <div class="form-group">
                                <label class="col-md-2 control-label" for="problem">Problem</label>

                                <div class="col-md-5">
                                    <select id="problem" name="problem" class="form-control">
                                        <?
                                        $state = $db->prepare("SELECT * FROM problems WHERE competition_id = ?");
                                        $state->execute(array(intval($fInfo[3][0])));
                                        $problems = $state->fetchAll();

                                        $state = $db->prepare("SELECT * FROM solved_problems WHERE team_id = ? AND competition_id = ? AND problem_id = ?");


                                        foreach ($problems as $problem) {
                                            $state->execute(array($_SESSION['team_id'], $problem['competition_id'], $problem['id']));
                                            $solved = $state->fetchAll();
                                            if (count($solved) == 0) {
                                                ?>
                                                <option
                                                    value="<? echo $problem['id']; ?>"><? echo $problem['problem_title']; ?></option>
                                            <?
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <!-- Textarea -->
                            <div class="form-group">
                                <label class="col-md-2 control-label" for="code">Code</label>

                                <div class="col-md-10">
                                    <textarea class="form-control" id="code" name="code" rows="10"></textarea>
                                </div>
                            </div>

                            <!-- Select Basic -->
                            <div class="form-group">
                                <label class="col-md-2 control-label" for="language">Language</label>

                                <div class="col-md-4">
                                    <select id="language" name="language" class="form-control">
                                        <option value="JAVA7">Java 7</option>
                                        <option value="JAVA8">Java 8</option>
                                        <option value="PYTHON2">Python 2</option>
                                        <option value="PYTHON3">Python 3</option>
                                        <option value="C">C</option>
                                        <option value="C++4.3">C++ 4.3</option>
                                        <option value="C++4.9">C++ 4.9</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Button -->
                            <div class="form-group">
                                <label class="col-md-2 control-label" for="submit"></label>

                                <div class="col-md-4">
                                    <button id="submit" name="submit" class="btn btn-primary">Submit My Code!</button>
                                </div>
                            </div>

                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="http://programmingcompetition.org/competitionSite/jquery.min.js"></script>
<script src="/js/bootstrap.min.js"></script>
<script>
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
            setTimeout(function () {
                competition()
            }, 4 * 1000);

        }, "json");
    }

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
    });

    $(".problem-submit").submit(function (e) {
        e.preventDefault();
        var problem = $("select[name=problem]").val();
        var code = $("textarea[name=code]").val();
        var language = $("select[name=language]").val();

        if (code.length < 50) {
            $(".alert-error").html("Please add more code! Your solution is too short.").show();
            return;
        }

        $(".alert-success").hide();
        $(".alert-danger").hide();
        $(".alert-info").show("slow");
        $(".problem-submit").hide();

        $.post("../assets/submitCode.php", {problem_id: problem, code: code, language: language},function (data) {
            console.log(data);
            if (data.success) {
                $(".alert-info").hide("slow");
                $(".alert-success").text(data.success).show();
                setTimeout(function () {
                    window.location.reload();
                }, 1000);
            } else {
                $(".alert-info").hide("slow");
                $(".alert-danger").text(data.error).show();
                $(".problem-submit").show();
            }
        }, "json").fail(function () {
            $(".alert-danger").text("Problem loading.").show();
                window.location.reload();
        });

    });
</script>
</body>
</html>