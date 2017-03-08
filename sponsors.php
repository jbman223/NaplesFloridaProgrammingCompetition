<?php
require_once "includes/require.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>The Naples Florida Programming Competition - Sponsors</title>


    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/site.css">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">

    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>

    <? echo $gaCode; ?>
</head>

<body>

<div class="container-fluid">

    <? require_once "content/menu.php"; ?>

    <div class="bg-container">
        <div class="row">
            <div class="container">

                <!-- PAGE CONTENT HERE -->
                <div class="row" id="about">
                    <div class="col-lg-3">

                    </div>
                    <div class="col-lg-6 text-center">
                        <h1>Sponsors</h1>
                    </div>
                    <div class="col-lg-3">

                    </div>
                </div>

                <div class="row">
                    <div class="col-md-2 col-sm-4 col-xs-6">
                        <a href="http://communityschoolnaples.org/"><img src="sliderPhotos/community.jpg" style="max-width: 100%;"/></a>
                    </div>
                    <div class="col-md-2 col-sm-4 col-xs-6">
                        <a href="http://agingcare.com"><img src="sliderPhotos/aging-care-logo.jpg" style="max-width: 100%;"/></a>
                    </div>
                    <div class="col-md-2 col-sm-4 col-xs-6">
                        <a href="http://swfrtp.org/"><img src="images/logo.png" style="max-width: 100%;" /></a>
                    </div>
                    <div class="col-md-2 col-sm-4 col-xs-6">
                        <a href="http://www.collierschools.com/site/default.aspx?PageID=1"><img src="images/collier-logo.png" style="max-width: 100%;" /></a>
                    </div>
                    <div class="col-md-2 col-sm-4 col-xs-6">

                    </div>
                    <div class="col-md-2 col-sm-4 col-xs-6">

                    </div>
                </div>
            </div>
        </div>


    </div>
</body>
</html>