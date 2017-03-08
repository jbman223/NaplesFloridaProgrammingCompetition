<?php
require_once "../../includes/require.php";

if (!isUserLoggedIn()) {
    header("Location: index.php");
    die();
}

if (isset($_GET['id'])) {
    $teamID = $_GET['id'];
    $state = $db->prepare("SELECT COUNT(*) FROM teams WHERE id = ? AND owner_id = ? AND deleted = ?");
    $state->execute(array($teamID, $_SESSION['id'], 0));
    $number = $state->fetchAll()[0][0];

    if ($number != 1) {
        header("Location: ../account.php");
        die();
    }
} else {
    header("Location: ../account.php");
    die();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>The Naples Florida Programming Competition - Add A Team Member</title>


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

                <!-- PAGE CONTENT HERE -->
                <div class="starter-template">
                    <h1>Register A Team Member</h1>

                    <p class="lead text-center">Add a new team member to your team.</p>
                </div>

                <div class="row">
                    <div class="col-lg-4 col-md-4 text-center">
                        <div class="center-block">
                            <p class="lead text-justify">
                                Please fill out the information for registering a team member <strong>accurately and
                                    honestly.</strong> False information will lead to disqualification from the
                                competition. After
                                creating a member's account, the member must validate their email and confirm they would
                                like to
                                join your team. You may have up to two members on one team.
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-8 col-md-8">
                        <div class="alert alert-danger text-center" role="alert" style="display: none;"></div>
                        <div class="alert alert-info text-center" role="alert" style="display: none;">Registering user,
                            please wait a second.
                        </div>
                        <div class="alert alert-success text-center" role="alert" style="display: none;">Please check
                            your email to
                            verify and complete your account!
                        </div>
                        <form class="form-horizontal register">
                            <fieldset>
                                <div class="form-group">
                                    <label class="col-md-2 control-label" for="f_name">First Name</label>

                                    <div class="col-md-10">
                                        <input id="f_name" name="f_name" placeholder="First Name"
                                               class="form-control input-md" required="" type="text">
                                        <span class="help-block">Enter your first name.</span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-2 control-label" for="l_name">Last Name</label>

                                    <div class="col-md-10">
                                        <input id="l_name" name="l_name" placeholder="Last Name"
                                               class="form-control input-md" required="" type="text">
                                        <span class="help-block">Enter your last name.</span>
                                    </div>
                                </div>


                                <div class="form-group">
                                    <label class="col-md-2 control-label" for="email">Email</label>

                                    <div class="col-md-10">
                                        <input id="email" name="email" placeholder="Email"
                                               class="form-control input-md" required="" type="text">
                                        <span class="help-block">Enter the participant's email. The participant will be contacted using this email. The participant will also need to verify this email in order to complete team eligibility.</span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-2 control-label" for="school">School</label>

                                    <div class="col-md-10">
                                        <input id="school" name="school" placeholder="School"
                                               class="form-control input-md" required="" type="text">
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
                                <input type="hidden" name="id" value="<? echo $_GET['id']; ?>"/>


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
        </div>


    </div>

    <script>
        $("input[name=f_name]").keydown(function (e) {
            if (e.which == 32) {
                e.preventDefault();
                $("input[name=l_name]").focus();
            }
        });

        $(".register").submit(function (e) {
            e.preventDefault();
            $(".register").slideUp();
            $(".alert-info").show();
            var f_name = $("input[name=f_name]").val();
            var l_name = $("input[name=l_name]").val();
            var email = $("input[name=email]").val();
            var school = $("input[name=school]").val();
            var grade = $("select[name=grade]").val();
            var shirt = $("select[name=shirt]").val();
            var id = $("input[name=id]").val();

            $.post("/registerAPI.php", {
                l_name: l_name,
                f_name: f_name,
                email: email,
                school: school,
                grade: grade,
                shirt: shirt,
                id: id,
                type: "register_team_member",
                csrf: $("input[name=csrf]").val()
            }, function (data) {
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
                            window.location = "../account.php";
                        }, 300);
                    }
                }
            }, "json")
        })
    </script>
</body>
</html>