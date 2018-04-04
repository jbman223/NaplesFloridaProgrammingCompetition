<?php
require_once "../content/require.php";

if (!isUserLoggedIn()) {
    header("Location: ../account/login.php");
}

if (!$user['admin']) {
    header("Location: ../account/login.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Administration Center</title>


    <link rel="stylesheet" href="../../css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/site.css">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">

    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="../../js/bootstrap.min.js"></script>

    <? echo $gaCode; ?>
</head>

<body>

<div class="container-fluid">

    <? require_once "../content/menu.php"; ?>

    <div class="bg-container">
        <div class="row">
            <div class="container">

                <!-- PAGE CONTENT HERE -->
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="text-center">Competition Administration Center</h1>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3">
                        <a href="problem"><h2>Problem Center</h2></a>
                    </div>
                    <div class="col-md-3">
                        <a href="quiz"><h2>Quiz Center</h2></a>
                    </div>
                    <div class="col-md-3">
                        <a href="competition"><h2>Competition Manager</h2></a>
                    </div>
                </div>

            </div>
        </div>


    </div>
</body>
</html>