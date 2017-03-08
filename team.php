<?php
require_once "includes/require.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>The Naples Florida Programming Competition - The Team</title>


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
                <div class="starter-template">
                    <h1>The Team</h1>

                    <p class="lead text-center">Founders of the competition.</p>
                </div>

                <div class="row">
                    <div class="col-lg-4 col-xs-4 text-center">
                        <div class="center-block">
                            <img src="sliderPhotos/Third_Front.jpeg" alt="Jacob Buckheit" style=""/>

                            <h3>Jacob Buckheit</h3>
                        </div>
                    </div>
                    <div class="col-lg-8 col-xs-8">
                        <p class="lead">I am Jacob Buckheit. I have been interested in programming since 7th grade, and interested
                            in computers for my entire life. I am a senior at Community School of Naples. Thanks to the support
                            of my school, my parents, my community and my friends I have been able to make my dreams of a
                            programming competition in Naples come true! I hope to continue this competition for many years, and
                            each year grow and improve the computer science community in Southwest Florida.<br>GitHub Profile: <a
                                href="https://github.com/jbman223">https://github.com/jbman223</a><br><a
                                href="mailto:jacob@buckheit.com">Email Me</a></a></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4 col-xs-4 text-center">
                        <div class="center-block">
                            <img src="sliderPhotos/IMG_4906.jpg"/>

                            <h3>Craig Schwerin</h3>
                        </div>
                    </div>
                    <div class="col-lg-8 col-xs-8">
                        <p class="lead">
                            My name is Craig Schwerin, a senior at Community School of Naples. I have always loved computers and
                            have programmed ever since I took AP Computer Science as a freshman. I have competed in programming
                            competitions for my school over years, but the problem was all these competition were several hours
                            outside of Collier County. Jacob and I wanted a competition in our own community that would foster
                            education and a love for computer science in our hometown of Southwest Florida. Over the years, I hope
                            to see this competition flourish into a driving force for Southwest Florida computer students and
                            businesses involved in the tech field.<br>Email me: <a href="mailto:craigthomasschwerin@gmail.com">craigthomasschwerin@gmail.com</a></p>
                    </div>
                </div>

            </div>
        </div>


    </div>
</body>
</html>