<?php
require_once "includes/require.php";
if (!isUserLoggedIn()) {
    header("Location: index.php");
    die();
}

$state = $db->prepare("SELECT * FROM `teams` WHERE `owner_id` = ? AND id = ? AND deleted = 0");
$state->execute(array($_SESSION['id'], $_GET['id']));
$teams = $state->fetchAll(PDO::FETCH_ASSOC);
if (count($teams) == 0) {
    header("Location: account.php");
    die();
}

$state = $db->prepare("SELECT * FROM `competitors` WHERE team_id = ? AND deleted = 0");
$state->execute(array($teams[0]['id']));
$competitors = $state->fetchAll();
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

    <title>Account - Naples Florida Programming Competition</title>

    <link href="/css/bootstrap.min.css" rel="stylesheet">

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
                            <li><a href="register.php">Register</a></li>
                            <li class="active"><a href="login.php">Log In</a></li>
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
        <h1>Team</h1>

        <p class="lead text-center">Manage your team.</p>
    </div>

    <div class="row">
        <div class="col-lg-4 col-sm-4">

        </div>
        <div class="col-lg-4 col-sm-4">
            <h3 class="text-center"><? echo $teams[0]['team_name']; ?></h3>
        </div>
        <div class="col-lg-4 text-center col-sm-4">
            <a href="registerTeamMember.php?id=<? echo $teams[0]['id']; ?>" class="btn btn-success">Add Member</a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <?
            if (count($competitors) > 0) {
                ?>
                <table class="table table-hover">
                    <tr>
                        <th>Member Name</th>
                        <th>Verified</th>
<!--                        <th>Edit Information</th>-->
                        <th>Delete Member</th>
                    </tr>
                    <? foreach ($competitors as $competitor) { ?>
                        <tr>
                            <td><? echo $competitor['f_name']." ".$competitor['l_name']; ?></td>
                            <? if ($competitor['verified'] == 1) { ?>
                                <td><span class="glyphicon glyphicon-ok"></span></td>
                            <? } else { ?>
                                <td><span class="glyphicon glyphicon-remove"></span></td>
                            <? } ?>
<!--                            <td><a href="editTeamMember.php?id=--><?// echo $competitor['id']; ?><!--" class="btn btn-info">Edit Member</a></td>-->
                            <td><a href="deleteMember.php?id=<? echo $competitor['id']; ?>" class="btn btn-info">Delete Member</a></td>
                        </tr>
                    <? } ?>
                </table>
            <?
            } else {
                ?>
                <p class="text-center lead">No members found for this team. Try adding one above.</p>
            <?
            }
            ?>

        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="/js/bootstrap.min.js"></script>
</body>
</html>
