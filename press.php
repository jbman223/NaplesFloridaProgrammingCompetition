<?php
require_once "includes/require.php";
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>The Naples Florida Programming Competition - High School Programming Competition</title>


    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/site.css">

    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>

    <? echo $gaCode; ?>
</head>

<body>

<div class="container-fluid">

    <?php require_once "content/menu.php"; ?>

    <div class="bg-container">
        <div class="row">
            <div class="container">

                <div class="starter-template">
                    <h1>Press</h1>

                    <p class="lead text-center">Official competition documents and information for free use in media.</p>
                </div>
                <br>

                <div class="row">
                    <div class="col-lg-4">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <h4 class="text-center">Competition Letter</h4>
                                <p class="lead text-justify">The competition letter was initially sent out to schools in order to inform them of the intent of the competition, and also to ask for participation of the students.<br><a href="https://drive.google.com/open?id=1rGaajVH2k4dhbIuqw5d6DorFSrP5Nk-A" target="_blank">Download The Letter</a></p>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <h4 class="text-center">Competition Poster 1</h4>
                                <p class="lead text-justify">
                                    The competition poster, designed by Steven Wulber and Michael Foiani, is available for download at full sized resolution.<br><a href="https://drive.google.com/open?id=1Vh0huRJC1FCw6DmqiRNIL3IKcUPJ7DxS">Download Poster</a>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <h4 class="text-center">Competition Poster 2</h4>
                                <p class="lead text-justify">This competition poster, designed by Kyle Dampier, is also available for download.<br><a href="https://drive.google.com/open?id=1Ndf5CxpZyPLebfT3Za1B-7iB_14d9HfK" target="_blank">View The Outline (Google Drive)</a></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <h4 class="text-center">Competition Quick Info</h4>
                                <ul class="lead">
                                    <li>Date: April 7th, <?php echo date("Y"); ?> at 8:45AM</li>
                                    <li>Location: <a href="https://www.google.com/maps/place/13275+Livingston+Road+Naples+Florida+3410">13275 Livingston Road, 34109</a></li>
                                    <li>Prizes: Prizes will be awarded to the top three placing teams.</li>
                                    <li>All competing teams will be given a T-Shirt.</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>
</body>
</html>