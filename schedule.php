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
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">

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

                <div class="row">
                    <div class="col-lg-3">

                    </div>
                    <div class="col-lg-6 text-center">
                        <h1>Schedule</h1>
                    </div>
                    <div class="col-lg-3">

                    </div>
                </div>

                <div class="row info-row hidden-print">

                    <div class="col-lg-6 col-sm-6 col-xs-6 text-center">
                        <p><span class="glyphicon glyphicon-calendar icon-font" aria-hidden="true"></span><br>WHEN</p>
                    </div>
                    <div class="col-lg-6 col-sm-6 col-xs-6 text-left">
                        <p class="lead">The competition will take place on <strong>Saturday, April 22rd, 2017</strong>. Mark your calendars!<br>Don't forget to sign up by April 12th!</p>
                    </div>
                </div>

                <div class="row info-row">
                    <div class="col-lg-6 text-center">
                        <p>
                            <span class="large-text">9:00 - 9:20</span>
                        </p>
                    </div>
                    <div class="col-lg-6">
                        <p class="lead text-left">Arrive at Community School of Naples Moe Kent Family Field House and check in for the day.
                            <span class="hidden-print"><a href="https://www.google.com/maps/place/13275+Livingston+Road+Naples+Florida+3410" target="_blank">View Map</a><br> Address: 13275 Livingston Road, Naples Florida, 34109</span></p>
                    </div>
                </div>

                <div class="row info-row">
                    <div class="col-lg-6 text-center">
                        <p>
                            <span class="large-text">9:20 - 9:35</span>
                        </p>
                    </div>
                    <div class="col-lg-6">
                        <p class="lead text-left">Introduction meeting and explanation of rules and competition proceedings.</p>
                    </div>
                </div>

                <div class="row info-row">
                    <div class="col-lg-6 text-center">
                        <p>
                            <span class="large-text">9:40 - 10:00</span>
                        </p>
                    </div>
                    <div class="col-lg-6">
                        <p class="lead text-left">Warm up round. This is the first round of the programming competition, where
                            teams will familiarize themselves with the equipment and questions may be asked. This round is not
                            scored, and is just for solving any technical issues.</p>
                    </div>
                </div>

                <div class="row info-row">
                    <div class="col-lg-6 text-center">
                        <p>
                            <span class="large-text">10:05 - 12:45</span>
                        </p>
                    </div>
                    <div class="col-lg-6">
                        <p class="lead text-left">Speed round. This round of the competition will consist of multiple problems of
                            varying difficulty, which each team will strive to complete the fastest. Each problem will be given a
                            set amount of points, and a correct response will award the team points for this problem.</p>
                    </div>
                </div>

                <div class="row info-row">
                    <div class="col-lg-6 text-center">
                        <p>
                            <span class="large-text">12:50 - 1:25</span>
                        </p>
                    </div>
                    <div class="col-lg-6">
                        <p class="lead text-left">Lunch! Pizza will be provided by Gulfstream Painting.</p>
                    </div>
                </div>

                <div class="row info-row">
                    <div class="col-lg-6 text-center">
                        <p>
                            <span class="large-text">1:30 - 2:30</span>
                        </p>
                    </div>
                    <div class="col-lg-6">
                        <p class="lead text-left">Mutliple Choice Round. Each team will be expected to complete
                            a AP style multiple choice test. These questions will be taken from past AP exams and
                            created by AP teachers or former AP Comper Science A students. It is not a huge factor
                            for score, but it will be scored. </p>
                    </div>
                </div>

                <div class="row info-row">
                    <div class="col-lg-6 text-center">
                        <p>
                            <span class="large-text">2:30 - 2:45</span>
                        </p>
                    </div>
                    <div class="col-lg-6">
                        <p class="lead text-left">Nap Time! Programming gets tough, and we understand that struggle!<br><br></p>
                    </div>
                </div>

                <div class="row info-row">
                    <div class="col-lg-6 text-center">
                        <p>
                            <span class="large-text">2:45 - 3:00</span>
                        </p>
                    </div>
                    <div class="col-lg-6">
                        <p class="lead text-left">Awards, prizes, and then your parents will pick you up.</p>
                    </div>
                </div>
            </div>
        </div>


    </div>
</body>
</html>