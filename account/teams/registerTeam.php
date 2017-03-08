<?php
require_once "../../includes/require.php";

if (!isUserLoggedIn()) {
    header("Location: index.php");
    die();
}

$state = $db->prepare("SELECT * FROM `teams` WHERE `owner_id` = ?");
$state->execute(array($_SESSION['id']));
$teams = $state->fetchAll(PDO::FETCH_ASSOC)[0];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>The Naples Florida Programming Competition - Register Team</title>


    <link rel="stylesheet" href="../../css/bootstrap.min.css">
    <link rel="stylesheet" href="../../css/site.css">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">

    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="../../js/bootstrap.min.js"></script>

    <? echo $gaCode; ?>
</head>

<body>

<div class="container-fluid">

    <? require_once "../../content/menu.php"; ?>

    <div class="bg-container">
        <div class="row">
            <div class="container">

                <div class="starter-template">
                    <h1>Register A Team</h1>

                    <p class="lead text-center">Register a team for the competition. You will add members to the team in the next
                        step.</p>
                </div>

                <div class="row">
                    <div class="col-lg-4 col-md-4 text-center">
                        <div class="center-block">
                            <p class="lead text-justify">
                                It is very easy to register a team for the competition. First, create the team using this page.
                                After you have successfully created a team, you can add up to two members to the team using the Account
                                Manager. <strong>All team names must be school appropriate, otherwise your team will be disqualified
                                    from competing in the 2015 competition.</strong>
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-8 col-md-8">
                        <div class="alert alert-danger text-center" role="alert" style="display: none;"></div>
                        <div class="alert alert-info text-center" role="alert" style="display: none;">Registering your team,
                            please wait a second.
                        </div>
                        <div class="alert alert-success text-center" role="alert" style="display: none;">Your team has been created.
                            You can now add members.
                        </div>
                        <form class="form-horizontal register">
                            <fieldset>


                                <div class="form-group">
                                    <label class="col-md-2 control-label" for="teamname">Team Name</label>

                                    <div class="col-md-10">
                                        <input id="teamname" name="teamname" placeholder="Team Name"
                                               class="form-control input-md" required="" type="text">
                                        <span class="help-block">Enter a team name! Keep it appropriate.</span>
                                    </div>
                                </div>

                                <? echo $csrf->outputCSRFForForm("register_team"); ?>


                                <div class="form-group">
                                    <div class="col-md-12 text-center">
                                        <button id="submit" name="submit" class="btn btn-info">Create Team</button>
                                    </div>
                                </div>

                            </fieldset>
                        </form>

                    </div>
                </div>

            </div>
        </div>


    </div>

    <script>
        $(".register").submit(function (e) {
            e.preventDefault();
            $(".register").slideUp();
            $(".alert-info").show();
            var name = $("input[name=teamname]").val();

            $.post("/registerAPI.php", {name: name, type: "register_team", csrf: $("input[name=csrf]").val()}, function (data) {
                console.log(data);
                if (data.error) {
                    $(".alert-info").hide();
                    $(".register").slideDown();
                    $(".alert-danger").text(data.error).show();
                } else {
                    $(".alert-info").hide();
                    $(".alert-success").show();
                    setTimeout(function () {
                        window.location = "../account.php";
                    }, 300);
                }
            }, "json")
        })
    </script>
</body>
</html>