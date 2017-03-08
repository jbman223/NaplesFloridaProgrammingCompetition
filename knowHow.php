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

    <title>Know This - Naples Florida Programming Competition</title>

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
            <h1>Know This Stuff!</h1>
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
                If you know how to program in Java, C, C++, or Python and can complete all of the items on this list, you
                will be able to preform very well in the competition!
            </p>
            <ul class="lead">
                <li>Reading input from the standard input.</li>
                <li>Basic string manipulation.</li>
                <li>Properly formatting output.</li>
                <li>Parsing a line of input.</li>
                <li>Arrays</li>
                <li>Math Classes</li>
                <li>Creating and using multiple classes in one file.</li>
                <li>Reading text from a file or standard input.</li>
                <li>Writing text to a file or standard output.</li>
                <li>Using Maps.</li>
                <li><a href="sampleProblems.php">View Sample Problems</a></li>
            </ul>
        </div>
        <div class="col-lg-2 col-sm-2 col-xs-2">
        </div>
    </div>
</div>
<!-- /.container -->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="/js/bootstrap.min.js"></script>
</body>
</html>
