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
                        <p class="lead">The competition will take place on <strong>Sunday, April 28th, <?php echo date("Y"); ?></strong>. Mark your calendars!<br>Don't forget to sign up by April 27th at the latest!</p>
                    </div>
                </div>

                <div class="row info-row">
                    <div class="col-lg-6 text-center">
                        <p>
                            <span class="large-text">2:30 - 2:40</span>
                        </p>
                    </div>
                    <div class="col-lg-6">
                        <p class="lead text-left">Arrive at Community School of Naples Library/LMA and check in for the day.
                            <span class="hidden-print"><a href="https://www.google.com/maps/place/13275+Livingston+Road+Naples+Florida+3410" target="_blank">View On Map</a><br> Address: 13275 Livingston Road, Naples Florida, 34109</span></p>
                            <span class="hidden-print">Refer to <a href="https://drive.google.com/file/d/1klj33virBcPj3fF9RUm5StrgVCarCSSe/view?usp=sharing" target="_blank">the parking map</a></span>
                    </div>
                </div>

                <div class="row info-row">
                    <div class="col-lg-6 text-center">
                        <p>
                            <span class="large-text">2:40-2:45</span>
                        </p>
                    </div>
                    <div class="col-lg-6">
                        <p class="lead text-left">Introduction meeting and explanation of rules and competition proceedings.</p>
                    </div>
                </div>

                <div class="row info-row">
                    <div class="col-lg-6 text-center">
                        <p>
                            <span class="large-text">2:55 - 3:15</span>
                        </p>
                    </div>
                    <div class="col-lg-6">
                        <p class="lead text-left">Tutorial round. This is the first round of the programming competition, where
                            teams will familiarize themselves with the equipment and questions may be asked. This round is not
                            scored, and is just for solving any technical issues. We will not proceed to the next round until
                            every contestant has correctly answered each question in this round.</p>
                    </div>
                </div>

                <div class="row info-row">
                    <div class="col-lg-6 text-center">
                        <p>
                            <span class="large-text">3:15-3:25</span>
                        </p>
                    </div>
                    <div class="col-lg-6">
                        <p class="lead text-left">Warm-up round. This round of the competition will consists of very easy problems,
                        which confirms that every contestant understands how to take inputs and submit. This round is also not
                            scored, and we will not proceed to the speed round until everyone has completed these questions.</p>
                    </div>
                </div>

                <div class="row info-row">
                    <div class="col-lg-6 text-center">
                        <p>
                            <span class="large-text">3:30 - 4:10</span>
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
                            <span class="large-text">4:30 - 5:20</span>
                        </p>
                    </div>
                    <div class="col-lg-6">
                        <p class="lead text-left">AP round. This round of the competition will consist of multiple problems based
                            off past AP exam FRQs. These questions will have many steps to them, will take much longer to complete,
                            and will match the difficulty of an AP exam. A correct response along with speed will determine the amount
                            of points received for each problem.</p>
                    </div>
                </div>

                <div class="row info-row">
                    <div class="col-lg-6 text-center">
                        <p>
                            <span class="large-text">5:25 - 6:05</span>
                        </p>
                    </div>
                    <div class="col-lg-6">
                        <p class="lead text-left">Multiple Choice Round. Each team will be expected to complete
                            an AP style multiple choice test. These questions will be taken from past AP exams and
                            created by AP teachers or former AP Computer Science A students. It is not a huge factor
                            for score, but it will be scored. </p>
                    </div>
                </div>

                <div class="row info-row">
                    <div class="col-lg-6 text-center">
                        <p>
                            <span class="large-text">6:15 - 6:30</span>
                        </p>
                    </div>
                    <div class="col-lg-6">
                        <p class="lead text-left">Dinner! Pizza will be provided by Gulfstream Painting.</p>
                        <p class="lead text-left">Awards, prizes, and then your parents will pick you up.</p>
                    </div>
                </div>
        </div>


    </div>
</body>
</html>