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

    <script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
    <script>tinymce.init({
            selector: '#problem_description',
            height: 300,
            theme: 'modern',
            plugins: [
                'advlist autolink lists link image charmap print preview hr anchor pagebreak',
                'searchreplace wordcount visualblocks visualchars code fullscreen',
                'insertdatetime media nonbreaking save table contextmenu directionality',
                'emoticons template paste textcolor colorpicker textpattern imagetools'
            ],
            toolbar1: 'insertfile undo redo | styleselect fontsizeselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
            toolbar2: 'preview media | forecolor backcolor emoticons',
            image_advtab: true
        });</script>

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
                        <label class="col-md-4 control-label" for="problem_name">Problem Name</label>

                        <div class="col-md-8">
                            <input id="problem_name" name="problem_name" placeholder="Name"
                                   class="form-control input-md" type="text">

                        </div>
                    </div>

                    <!-- Textarea -->
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="problem_description">Problem Description</label>

                        <div class="col-md-8">
                            <textarea class="form-control" id="problem_description"
                                      name="problem_description"></textarea>
                        </div>
                    </div>

                    <!-- Textarea -->
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="problem_sample_input">Problem Sample Input</label>

                        <div class="col-md-8">
                            <textarea class="form-control" id="problem_sample_input"
                                      name="problem_sample_input"></textarea>
                        </div>
                    </div>

                    <!-- Textarea -->
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="problem_sample_output">Problem Sample Output</label>

                        <div class="col-md-8">
                            <textarea class="form-control" id="problem_sample_output"
                                      name="problem_sample_output"></textarea>
                        </div>
                    </div>

                    <!-- Textarea -->
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="sample_code">Problem Sample Code</label>

                        <div class="col-md-8">
                            <textarea class="form-control" id="sample_code" name="sample_code"></textarea>
                        </div>
                    </div>

                    <!-- Text input-->
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="youtube_video_link">Problem Video Link</label>

                        <div class="col-md-8">
                            <input id="youtube_video_link" name="youtube_video_link" placeholder="http://youtu.be/"
                                   class="form-control input-md" type="text">

                        </div>
                    </div>

                    <!-- Button -->
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="submit"></label>

                        <div class="col-md-4">
                            <button id="submit" name="submit" class="btn btn-primary">Create Problem</button>
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

    $(function () {
        loadServerTime();
        competition();
    });

    $("input[name=youtube_video_link]").keyup(function () {
        var regExp = /^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#\&\?]*).*/;
        var match = $(this).val().match(regExp);
        if (match && match[7].length == 11) {
            $(this).val(match[7]).prop("disabled", "disabled").parent().parent().removeClass("has-error").addClass("has-success");
        } else {
            $(this).parent().parent().removeClass("has-success").addClass("has-error");
        }
    });

    $(".create").submit(function (e) {
        e.preventDefault();
        var postObj = {};
        $(this).find("input, textarea").each(function () {
            if ($(this).attr('name') === "problem_description") {
                postObj[$(this).attr('name')] = tinyMCE.get('problem_description').getContent();
            } else {
                postObj[$(this).attr("name")] = $(this).val();
            }
        });
        postObj.type = "create_edu_problem";
        $(".create").hide("fast");
        $(".alert-danger").hide("fast");
        $(".alert-info").show("fast");
        $(".alert-success").hide("fast");
        console.log(postObj);
        $.post("../../assets/api.php", postObj, function (e) {
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