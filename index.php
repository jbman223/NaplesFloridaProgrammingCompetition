<?php
require_once "includes/require.php";
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>The Naples Florida Programming Competition - High School Programming Competition</title>

    <meta name="description"
          content="The Naples Florida Programming Competition is the premier high school programming competition in Southwest Florida. Come compete this year for a chance to win awesome prizes!">

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/site.css">

    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>

    <? echo $gaCode; ?>
</head>

<body>

<div class="container-fluid">

    <?php include_once "content/menu.php"; ?>

    <div class="bg-container">
        <div class="row" style="margin: -10px -25px 15px;">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="image">
                    <img src="/images/index/IMG_8289.jpg" style="width: 100%;border-radius: 3px 3px 0 0;"/>

                    <h2>
                        <span>Don't forget to sign up for the <?php echo date("Y") ?> competition!<br /><a href="2016" style="color:white;">Check out last year's album!</a></span>
                    </h2>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="container">
                <div class="row" id="about">
                    <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
                        <img src="/images/index/IMG_8243.jpg" class="main-image"/>

                        <h3 class="text-center">About the Competition</h3>

                        <p class="text-justify lead info">
                            Find all of the information you need to know for the competition!
                        </p>

                        <div class="text-center">
                            <a class="btn btn-info" href="about.php" role="button">More Info <span
                                    class="glyphicon glyphicon-chevron-right"></span></a>
                            <br><br>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
                        <img src="/images/IMG_8305.jpg" class="main-image"/>

                        <h3 class="text-center">Register Your Team</h3>

                        <p class="text-justify lead info">
                            Register your team to compete in the competition.
                        </p>

                        <div class="text-center">
                            <a class="btn btn-info" href="account/register.php" role="button">Register Now <span
                                    class="glyphicon glyphicon-chevron-right"></span></a>
                            <br><br>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
                        <img src="/images/index/IMG_8383.jpg" class="main-image"/>

                        <h3 class="text-center">Practice Problems</h3>

                        <p class="text-justify lead info">
                            Practice programming previous NFPC problems.
                        </p>

                        <div class="text-center">
                            <a class="btn btn-info" href="/edu" role="button">Practice <span
                                    class="glyphicon glyphicon-chevron-right"></span></a>
                            <br><br>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="row hidden-xs hidden-sm sponsors">
            <div class="col-md-2">

            </div>
        </div>

    </div>
</body>
</html>