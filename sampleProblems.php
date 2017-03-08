<?php
require_once "includes/require.php";
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

    <title>Sample Problems - Naples Florida Programming Competition</title>

    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="jb.css" rel="stylesheet">

    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <![endif]-->

    <? echo $gaCode; ?>
</head>

<body>

<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                    aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li><a href="index.php">Home</a></li>
                <li class="dropdown active">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">About
                        <span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li class="active"><a href="about.php">General Information</a></li>
                        <li><a href="schedule.php">Schedule</a></li>
                        <li><a href="team.php">The Team</a></li>
                        <li class="divider"></li>
                        <li class="dropdown-header">Downloads</li>
                        <li><a href="downloads/OfficialLetter.pdf">Competition Letter</a></li>
                        <li>
                            <a href="https://docs.google.com/document/d/1oaaPaCS3qvEnrTVn1q2OmQOJzSglOmfygI2S_cmIeFc/edit?usp=sharing"
                               target="_blank">Official Outline</a></li>
                        <li><a href="downloads/pcp.jpg" target="_blank">Competition Poster</a></li>
                        <li><a href="downloads/WebsiteWalkthrough.pdf" target="_blank">Website Walk-Through</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Account
                        <span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <? if (!isUserLoggedIn()) { ?>
                            <li><a href="register.php">Register</a></li>
                            <li><a href="login.php">Log In</a></li>
                        <? } else { ?>
                            <li><a href="account.php">Account Manager</a></li>
                            <li><a href="logout.php">Log Out</a></li>
                        <? } ?>
                    </ul>
                </li>
                <li><a href="sponsors.php">Sponsors</a></li>
                <li><a href="press.php">Press</a></li>
                <li><a href="contact.php">Contact</a></li>
            </ul>
        </div>
        <!--/.nav-collapse -->
    </div>
</nav>

<div class="container">

    <div class="row" id="about">
        <div class="col-lg-3">

        </div>
        <div class="col-lg-6 text-center">
            <h1>Sample Problems</h1>
        </div>
        <div class="col-lg-3">

        </div>
    </div>
    <br>

    <div class="row">
        <div class="col-lg-2 col-sm-2 col-xs-2">
        </div>
        <div class="col-lg-8 col-sm-8 col-xs-8">
            <p class="lead">
                Here are some sample problems for competition day! Check back here often, as we will be adding more sample problems and more interactive practice options in the very near future!
            </p>
        </div>
        <div class="col-lg-2 col-sm-2 col-xs-2">
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-4">
            <ul class="lead">
                <li>iPod Simulator
                    <ul class="lead">
                        <li><a href="/downloads/sampleProblems/iPodSimulator/iPodSimulatorDescription.pdf" target="_blank">Problem description</a></li>
                        <li><a href="/downloads/sampleProblems/iPodSimulator/input.txt" target="_blank">Sample Input</a></li>
                        <li><a href="/downloads/sampleProblems/iPodSimulator/iPodProblem.java" target="_blank">Sample Solution Code (Java)</a></li>
                    </ul>
                </li>
                <li>Jimmy’s Carrots and the Lochness Monster
                    <ul class="lead">
                        <li><a href="/downloads/sampleProblems/Jimmy/Jimmy.pdf" target="_blank">Problem description</a></li>
                        <li><a href="/downloads/sampleProblems/Jimmy/JimmyInput.txt" target="_blank">Sample Input</a></li>
                        <li><a href="/downloads/sampleProblems/Jimmy/Jimmy.java" target="_blank">Sample Solution Code (Java)</a></li>
                    </ul>
                </li>
            </ul>
        </div>
        <div class="col-lg-8 col-md-8 col-sm-8">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h4 class="text-center">Submit Your Solution</h4>
                    <p class="lead text-justify">Submit your solution to any of the sample problems here. This allows you to check your code in a competition-like setting and get used to how the code will be judged at the competition.</p>
                    <div class="alert alert-info text-center" role="alert" style="display: none;">Running code, please wait.
                    </div>
                    <div class="alert alert-success text-center" role="alert" style="display: none;">
                    </div>
                    <div class="alert alert-danger text-center" role="alert" style="display: none;">
                    </div>
                    <form class="form-horizontal sample-problem-submit">
                        <fieldset>
                            <!-- Select Basic -->
                            <div class="form-group">
                                <label class="col-md-2 control-label" for="problem">Problem</label>
                                <div class="col-md-4">
                                    <select id="problem" name="problem" class="form-control">
                                        <option value="1">iPod Simulator</option>
                                        <option value="2">Jimmy’s Carrots and the Lochness Monster</option>
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
<!-- /.container -->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="/js/bootstrap.min.js"></script>
<script>
    $(".sample-problem-submit").submit(function (e) {
        e.preventDefault();
        var problem = $("select[name=problem]").val();
        var code = $("textarea[name=code]").val();
        var language = $("select[name=language]").val();

        if (code < 50) {
            $(".alert-error").html("Please add more code! Your solution is too short.").show();
            return;
        }

        $.post("/sampleSubmissionAPI/createSubmission.php", {problem: problem, code: code, language: language}, function(data) {
            if (data.success) {
                $(".alert-error").hide();
                $(".alert-info").show();
                function getSubmissionResult() {
                    $.get("/sampleSubmissionAPI/getSubmissionStatus.php", function(data) {
                        if (data.success) {
                            $.get("/sampleSubmissionAPI/getSubmissionResult.php", function(data) {
                                if (data.error) {
                                    $(".alert-danger").html(data.error).show();
                                    $(".alert-info").hide();
                                } else {
                                    $(".alert-info").hide();
                                    $(".alert-danger").hide();
                                    $(".alert-success").html(data.success).show();
                                }
                            }, "json");
                        } else if (data.wait) {
                            setTimeout(getSubmissionResult(), 500);
                        } else {
                            $(".alert-danger").html(data.error).show();
                            $(".alert-info").hide();
                        }
                    }, "json");
                }

                setTimeout(getSubmissionResult(), 500);
            } else {
                console.log(data.error);
                $(".alert-danger").show().html(data.error);
            }
        }, "json").fail(function() {    alert( "error" );  });

    });


</script>
</body>
</html>
