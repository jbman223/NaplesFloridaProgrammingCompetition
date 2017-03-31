<?
require_once "api/require.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="The official Naples Florida Programming Competition.">
    <meta name="author" content="Jacob Buckheit">
    <link rel="icon" href="../favicon.ico">

    <title>Naples Florida Programming Competition</title>

    <link href="/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/jb.css" rel="stylesheet">
    <link href="codemirror/lib/codemirror.css" rel="stylesheet">
    <link href="codemirror/addon/hint/show-hint.css" rel="stylesheet">
    <link href="codemirror/theme/ambiance.css" rel="stylesheet">
    <link href="codemirror/theme/ambiance-mobile.css" rel="stylesheet">

    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <![endif]-->

    <style>
        body {
            padding-top: 0;
        }

        .header-logo {
            background: url('../2015/img/Title_Blurred.jpg') top no-repeat #4c6282 fixed;
            background-size: cover;
        }

        .logo-text {
            margin-top: -10px;
            color: white;
            text-shadow: 2px 1px 3px rgba(0, 0, 0, 0.5);
            font-weight: lighter;
        }
    </style>

    <? echo $gaCode; ?>
</head>

<body>
<div class="container-fluid">
    <div class="row header-logo">
        <div class="col-md-3">
        </div>
        <div class="col-md-6 text-center">
            <a href="/index.php"><img src="../images/WhiteShadowLogo.png" style="max-width: 100%;"/></a>

            <h1 class="logo-text">Education Center</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-md-3">

        </div>
        <div class="col-md-6">
            <h1 class="text-center">Create an account or log in to access all features of the Education Center</h1>
        </div>
    </div>

    <div class="row" style="margin-bottom: 15px;">
        <div class="col-md-3">

        </div>
        <div class="col-md-3 text-center">
            <a href="../account/register.php?redirect=/edu" class="btn btn-block btn-lg btn-primary">Create Account</a>
        </div>
        <div class="col-md-3 text-center">
            <a href="../account/login.php?redirect=/edu" class="btn btn-block btn-lg btn-primary">Sign In</a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-3">

        </div>
        <div class="col-md-6">

            <p class="lead">
                <img class="pull-left" style="max-width: 300px;"
                     src="../images/EDUPreview.png"/>
                Watch video tutorials for ProgrammingCompetition.org problems while you write and compile code for the
                problems at the same time. Get tips from the creators of the problems on the most efficient way to solve
                the problem and other problems like it. Save your progress on these problems in the cloud so you never
                lose your progress.
            </p>
        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="/js/bootstrap.min.js"></script>
</body>
</html>
