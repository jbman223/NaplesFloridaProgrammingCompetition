<?php
require_once "assets/require.php";
if (isLoggedIn()) {
    header("Location: index.php");
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

    <title>NFPC Competition Manager</title>

    <link href="/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="/jb.css" rel="stylesheet">

    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <![endif]-->
</head>

<body>
<div class="container">

    <div class="starter-template">
        <h1>Log In</h1>
    </div>

    <div class="row">
        <div class="col-lg-4 col-md-4 text-center">
            <div class="center-block">
                <p class="lead text-justify">
                    Log in to your account using the username and password given to you in your registration packet. If
                    you did not receive a packet or do not know how to find this information, please raise your hand and
                    a volunteer will be there shortly.
                </p>
            </div>
        </div>
        <div class="col-lg-8 col-md-8">
            <div class="alert alert-danger text-center" role="alert" style="display: none;"></div>
            <div class="alert alert-info text-center" role="alert" style="display: none;">Logging you in.</div>
            <div class="alert alert-success text-center" role="alert" style="display: none;">Thank you for logging in!
            </div>
            <form class="form-horizontal login">
                <fieldset>


                    <!-- Text input-->
                    <div class="form-group">
                        <label class="col-md-2 control-label" for="email">Username</label>

                        <div class="col-md-10">
                            <input id="email" name="email" placeholder="Username"
                                   class="form-control input-md" required="" type="text">
                            <span class="help-block">Enter the username given on your registration sheet.</span>
                        </div>
                    </div>

                    <!-- Password input-->
                    <div class="form-group">
                        <label class="col-md-2 control-label" for="password">Password</label>

                        <div class="col-md-10">
                            <input id="password" name="password" placeholder="***********" class="form-control input-md"
                                   required="" type="password">
                            <span class="help-block">Enter the password given on your registration sheet.</span>
                        </div>
                    </div>

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

<script src="jquery.min.js"></script>
<script src="/js/bootstrap.min.js"></script>
<script>
    $(".login").submit(function (e) {
        e.preventDefault();
        $(".register").slideUp();
        $(".alert-info").show();
        var email = $("input[name=email]").val();
        var password = $("input[name=password]").val();

        $.post("assets/api.php", {email: email, password: password, type: "login_account"}, function (data) {
            console.log(data);
            if (data.error) {
                $(".alert-info").hide();
                $(".register").slideDown();
                $(".alert-danger").text(data.error).show();
                if (data.code == 0) {
                    setTimeout(function () {
                        window.location = "index.php";
                    }, 250);
                }
            } else {
                $(".alert-info").hide();
                $(".alert-success").show();
                if (data.success) {
                    setTimeout(function () {
                        window.location = "index.php";
                    }, 250);
                }
            }
        }, "json").fail(function (xhr, textStatus, errorThrown) {
            console.log(textStatus);
            alert(xhr.responseText);
        })
    })
</script>
</body>
</html>