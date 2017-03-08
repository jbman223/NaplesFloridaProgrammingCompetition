<?php
require_once "includes/require.php";

if (!isUserLoggedIn()) {
    header("Location: index.php");
    die();
}

if (isset($_GET['id'])) {
    $memberID = $_GET['id'];
    $state = $db->prepare("SELECT *, COUNT(*) FROM competitors WHERE id = ? AND deleted = ?");
    $state->execute(array($memberID, 0));
    $competitor = $state->fetchAll();
    $number = $competitor[0]['COUNT(*)'];

    if ($number != 1) {
        header("Location: index.php");
        die();
    }

    $state = $db->prepare("SELECT COUNT(*) FROM teams WHERE id = ? AND owner_id = ?");
    $state->execute(array($competitor[0]['team_id'], $_SESSION['id']));
    $team = $state->fetchAll();

    if ($team[0][0] != 1) {
        header("Location: index.php");
        die();
    }

    $competitor = $competitor[0];
} else {
    header("Location: ".$_SERVER['HTTP_REFERER']);
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

    <title>Edit Team Member - Naples Florida Programming Competition</title>

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
        <h1>Edit A Team Member</h1>

        <p class="lead text-center">Edit the imformation of a team member.</p>
    </div>

    <div class="row">
        <div class="col-lg-4 col-md-4 text-center">
            <div class="center-block">
                <p class="lead text-justify">
                    Change any information about a team member. If the email for this team member is incorrect, please delete the team member and create a new one.
                </p>
            </div>
        </div>
        <div class="col-lg-8 col-md-8">
            <div class="alert alert-danger text-center" role="alert" style="display: none;"></div>
            <div class="alert alert-info text-center" role="alert" style="display: none;">Updating user,
                please wait a second.
            </div>
            <div class="alert alert-success text-center" role="alert" style="display: none;">The user information has been updated.
            </div>
            <form class="form-horizontal register">
                <fieldset>
                    <div class="form-group">
                        <label class="col-md-2 control-label" for="f_name">First Name</label>

                        <div class="col-md-10">
                            <input id="f_name" name="f_name" placeholder="First Name"
                                   class="form-control input-md" required="" type="text" value="<? echo $competitor['f_name']; ?>">
                            <span class="help-block">Enter your first name.</span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-2 control-label" for="l_name">Last Name</label>

                        <div class="col-md-10">
                            <input id="l_name" name="l_name" placeholder="Last Name"
                                   class="form-control input-md" required="" type="text" value="<? echo $competitor['l_name']; ?>">
                            <span class="help-block">Enter your last name.</span>
                        </div>
                    </div>


                    <div class="form-group">
                        <label class="col-md-2 control-label" for="email">Email</label>

                        <div class="col-md-10">
                            <input id="email" name="email" placeholder="Email"
                                   class="form-control input-md disabled" required="" type="text"  disabled="" value="<? echo $competitor['email']; ?>">
                            <span class="help-block">Enter the participant's email. The participant will be contacted using this email. The participant will also need to verify this email in order to complete team eligibility.</span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-2 control-label" for="school">School</label>

                        <div class="col-md-10">
                            <input id="school" name="school" placeholder="School"
                                   class="form-control input-md" required="" type="text" value="<? echo $competitor['school']; ?>">
                            <span class="help-block">Enter the full name of the school you attend.</span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-2 control-label" for="grade">Grade</label>

                        <div class="col-md-10">
                            <select id="grade" name="grade" class="form-control">
                                <option value="9">9</option>
                                <option value="10">10</option>
                                <option value="11">11</option>
                                <option value="12">12</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-2 control-label" for="shirt">Shirt Size</label>

                        <div class="col-md-10">
                            <select id="shirt" name="shirt" class="form-control">
                                <option value="S">Small</option>
                                <option value="M">Medium</option>
                                <option value="L">Large</option>
                                <option value="XL">X-Large</option>
                            </select>
                        </div>
                    </div>

                    <? echo $csrf->outputCSRFForForm("register_team_member"); ?>
                    <input type="hidden" name="id" value="<? echo $_GET['id']; ?>" />


                    <div class="form-group">
                        <div class="col-md-12 text-center">
                            <button id="submit" name="submit" class="btn btn-info">Add Member</button>
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
        var f_name = $("input[name=f_name]").val();
        var l_name = $("input[name=l_name]").val();
        var school = $("input[name=school]").val();
        var grade = $("select[name=grade]").val();
        var shirt = $("select[name=shirt]").val();
        var id = $("input[name=id]").val();

        $.post("registerAPI.php", {l_name: l_name, f_name: f_name, email: email, school: school, grade: grade, shirt: shirt, id: id, type: "register_team_member", csrf: $("input[name=csrf]").val()}, function (data) {
            console.log(data);
            if (data.error) {
                $(".alert-info").hide();
                $(".register").slideDown();
                $(".alert-danger").text(data.error).show();
            } else {
                $(".alert-info").hide();
                $(".alert-success").show();
                if (data.success) {
                    setTimeout(function () {
                        window.location = "account.php";
                    }, 300);
                }
            }
        }, "json").fail(function (xhr, textStatus, errorThrown) {
            alert(xhr.responseText);
        })
    })
</script>
</body>
</html>
