<?php
require_once "includes/require.php";
if (!isUserLoggedIn()) {
    header("Location: index.php");
    die();
}

if (isset($_GET['id'])) {
    $competitorID = $_GET['id'];
    $state = $db->prepare("SELECT team_id, COUNT(*) FROM competitors WHERE id = ?");
    $state->execute(array($competitorID));
    $ret = $state->fetchAll();
    $number = $ret[0]['COUNT(*)'];

    $state = $db->prepare("SELECT COUNT(*) FROM teams WHERE id = ? AND owner_id = ? AND deleted = ?");
    $state->execute(array($ret[0]['team_id'], $_SESSION['id'], 0));
    $isOwner = $state->fetchAll()[0][0] == 1;

    if ($number != 1 || !$isOwner) {
        die(json_encode(array("error" => "That competitor does not exist.")));
    }
}

if (isset($_POST['csrf'], $_POST['id']) && $csrf->validateCSRF("delete", $_POST['csrf'])) {
    $competitorID = $_POST['id'];
    $state = $db->prepare("SELECT team_id, COUNT(*) FROM competitors WHERE id = ?");
    $state->execute(array($competitorID));
    $ret = $state->fetchAll();
    $competitors = $ret[0]['COUNT(*)'];

    $state = $db->prepare("SELECT COUNT(*) FROM teams WHERE id = ? AND owner_id = ? AND deleted = ?");
    $state->execute(array($ret[0]['team_id'], $_SESSION['id'], 0));
    $number = $state->fetchAll()[0][0];
    if ($number == 1) {
        $state = $db->prepare("UPDATE competitors SET deleted = ? WHERE id = ?");
        $state->execute(array(1, $_POST['id']));
        die(json_encode(array("success" => "Your team has been deleted!")));
    } else {
        die(json_encode(array("error" => "You cannot delete that team.")));
    }
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

    <title>Delete Team - Naples Florida Programming Competition</title>

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
        <div class="content">
            <h1>Delete Team Member</h1>

            <p class="lead text-center">Are you sure you would like to delete this member? You can not undo this
                action.</p>

            <div class="text-center">
                <? echo $csrf->outputCSRFForForm("delete"); ?>
                <input type="hidden" name="id" value="<? echo $_GET['id']; ?>">
                <button type="button" class="btn btn-danger logout">Delete Member</button>
                <button type="button" class="btn btn-default cancel">Cancel</button>
            </div>
        </div>
        <div class="alerts" style="display: none;">
            <div class="alert alert-danger text-center" role="alert" style="display: none;"></div>
            <div class="alert alert-info text-center" role="alert" style="display: none;">Deleting,
                please wait a second.
            </div>
            <div class="alert alert-success text-center" role="alert" style="display: none;">You have deleted this member.
            </div>
        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="/js/bootstrap.min.js"></script>
<script type="text/javascript">
    $(".logout").click(function () {
        $(".content").slideUp();
        $(".alerts").show();
        $.post("deleteMember.php", {csrf: $("input[name=csrf]").val(), id: $("input[name=id]").val()},function (data) {
            console.log(data);
            $(".alert-success").show();
            if (data.success) {
                setTimeout(function () {
                    window.location = "<? echo $_SERVER['HTTP_REFERER'] ?>";
                }, 450);
            }

            if (data.error) {
                $(".alert-danger").text(data.error).show();

            }
        }, "json").fail(function (xhr, textStatus, errorThrown) {
            console.log(xhr);
            alert(xhr.responseText);
            alert(textStatus);
            alert(errorThrown);
        });
    });
    $(".cancel").click(function () {
        window.location = "<? echo $_SERVER['HTTP_REFERER'] ?>";
    });
</script>
</body>
</html>
