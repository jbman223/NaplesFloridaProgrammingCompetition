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

    <title>Register - Naples Florida Programming Competition</title>

    <link href="/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="jb.css" rel="stylesheet">

    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <![endif]-->
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

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">About
                        <span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="about.php">General Information</a></li>
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
                <li class="dropdown active">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Account
                        <span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <? if (!isUserLoggedIn()) { ?>
                            <li class="active"><a href="register.php">Register</a></li>
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

    <div class="starter-template">
        <h1>Register</h1>

        <p class="lead text-center">Register to compete in the competition. <strong>Please register your team by March 18th.</strong></p>
    </div>

    <div class="row">
        <div class="col-lg-4 col-md-4 text-center">
            <div class="center-block">
                <p class="lead text-justify">
                    Registering for the competition is easy. Just complete the form. This form will sign you up for a
                    <strong>Team Account</strong>. The team account will then go through the
                    complete process of registering a team for the competition.
                </p>
            </div>
        </div>
        <div class="col-lg-8 col-md-8">
            <div class="alert alert-danger text-center" role="alert" style="display: none;"></div>
            <div class="alert alert-info text-center" role="alert" style="display: none;">Registering your account,
                please wait a second.
            </div>
            <div class="alert alert-success text-center" role="alert" style="display: none;">Please check your email to
                verify and complete your account!
            </div>
            <form class="form-horizontal register">
                <fieldset>


                    <!-- Text input-->
                    <div class="form-group">
                        <label class="col-md-2 control-label" for="email">Email</label>

                        <div class="col-md-10">
                            <input id="email" name="email" placeholder="Email"
                                   class="form-control input-md" required="" type="text">
                            <span class="help-block">Enter your email. This email will be used to recover your account in case you lose access. You will also log into your account using this email.</span>
                        </div>
                    </div>

                    <!-- Password input-->
                    <div class="form-group">
                        <label class="col-md-2 control-label" for="password">Password</label>

                        <div class="col-md-10">
                            <input id="password" name="password" placeholder="***********" class="form-control input-md"
                                   required="" type="password">
                            <span class="help-block">Enter a password to log into your account with.</span>
                        </div>
                    </div>

                    <? echo $csrf->outputCSRFForForm("register"); ?>


                    <div class="form-group">
                        <div class="col-md-12 text-center">
                            <button id="submit" name="submit" class="btn btn-info">Create Account</button>
                        </div>
                    </div>

                </fieldset>
            </form>

        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="/js/bootstrap.min.js"></script>
<script>
    $(".register").submit(function (e) {
        e.preventDefault();
        $(".register").slideUp();
        $(".alert-info").show();
        var email = $("input[name=email]").val();
        var password = $("input[name=password]").val();

        $.post("registerAPI.php", {email: email, password: password, type: "register_account", csrf: $("input[name=csrf]").val()},function (data) {
            console.log(data);
            if (data.error) {
                $(".alert-info").hide();
                $(".register").slideDown();
                $(".alert-danger").text(data.error).show();
            } else {
                $(".alert-info").hide();
                $(".alert-success").show();
            }
        }, "json").fail(function (xhr, textStatus, errorThrown) {
            alert(xhr.responseText);
        })
    })
</script>
</body>
</html>
