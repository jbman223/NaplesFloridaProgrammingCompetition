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

    <title>Log In - Naples Florida Programming Competition</title>

    <link href="/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="jb.css" rel="stylesheet">

    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <![endif]-->
</head>

<body>

<? include_once "includes/menu.php"; ?>

<div class="container">

    <div class="starter-template">
        <h1>Log In</h1>

        <p class="lead text-center">Log in to your competition account.</p>
    </div>

    <div class="row">
        <div class="col-lg-4 col-md-4 text-center">
            <div class="center-block">
                <p class="lead text-justify">
                    Log in to your account. From your account, you can create teams and add members to these teams.
                    These teams will be the final teams which will compete in the competition.
                </p>
            </div>
        </div>
        <div class="col-lg-8 col-md-8">
            <div class="alert alert-danger text-center" role="alert" style="display: none;"></div>
            <div class="alert alert-info text-center" role="alert" style="display: none;">Logging you in.</div>
            <div class="alert alert-success text-center" role="alert" style="display: none;">Thank you for logging in!
            </div>
            <form class="form-horizontal register">
                <fieldset>


                    <!-- Text input-->
                    <div class="form-group">
                        <label class="col-md-2 control-label" for="email">Email</label>

                        <div class="col-md-10">
                            <input id="email" name="email" placeholder="jbuckheit2016@communityschoolnaples.org"
                                   class="form-control input-md" required="" type="text">
                            <span class="help-block">Enter your email.</span>
                        </div>
                    </div>

                    <!-- Password input-->
                    <div class="form-group">
                        <label class="col-md-2 control-label" for="password">Password</label>

                        <div class="col-md-10">
                            <input id="password" name="password" placeholder="***********" class="form-control input-md"
                                   required="" type="password">
                            <span class="help-block">Enter your password.</span>
                        </div>
                    </div>

                    <? echo $csrf->outputCSRFForForm("login"); ?>


                    <div class="form-group">
                        <div class="col-md-12 text-center">
                            <button id="submit" name="submit" class="btn btn-info">Log In</button>
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

        $.post("registerAPI.php", {email: email, password: password, type: "login_account", csrf: $("input[name=csrf]").val()},function (data) {
            console.log(data);
            if (data.error) {
                $(".alert-info").hide();
                $(".register").slideDown();
                $(".alert-danger").text(data.error).show();
                if (data.code == 0) {
                    setTimeout(function () {
                        window.location = "account.php";
                    }, 250);
                }
            } else {
                $(".alert-info").hide();
                $(".alert-success").show();
                if (data.success) {
                    setTimeout(function () {
                        window.location = "<? echo $_GET['redirect']; ?>";
                    }, 250);
                }
            }
        }, "json").fail(function (xhr, textStatus, errorThrown) {
            alert(xhr.responseText);
        })
    })
</script>
</body>
</html>
