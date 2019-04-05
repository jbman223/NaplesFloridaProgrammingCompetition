<?php
require_once "assets/require.php";
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

    <title>Register Team - Naples Florida Programming Competition</title>

    <link href="/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->

    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <![endif]-->
    <style>
        body {
            background: #303030 url('../2015/img/IMG_6082.JPG');
            background-size: cover;
        }
        .thing {
            color:#f0f0f0;
            background: #303030;
            font-size:14pt;
            font-family:'Courier New';
            min-height: 100vh;
            max-height: 100vh;
            overflow: hidden;
            z-index: 999;
        }
        .title {
            color: #fff;
            z-index: 11111;
            position: absolute;
            margin: 0 auto;
        }
    </style>
</head>

<body>
<div class="thing">
    <div class="title center-block"><h1 class="text-center">The Naples Florida Programming Competition</h1></div>

</div>

<script src="http://programmingcompetition.org/competitionSite/jquery.min.js"></script>
<script src="/js/bootstrap.min.js"></script>
<script>
    $(function () {
        $.get("../highlightedCode.php", function (data) {
            var lines = data.split("<");
            console.log(lines.length + " lines in this document");
            $.each(lines, function (i, line) {
                if (i == 0) {
                    console.log(line);
                }

                if (i==0) {
                    setTimeout(function () {
                        $(".thing").append(line);
                    }, i * 100);
                } else {
                    setTimeout(function () {
                        $(".thing").append("<"+line);
                    }, i * 100);
                }
            })
        }, "html");
    });

    $(window).load(function () {
    });
</script>
</body>
</html>
