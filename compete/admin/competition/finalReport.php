<?php
require_once "../../content/require.php";
require_once "../../api/scoreboard/calculateLeaderboard.php";

if (!isUserLoggedIn()) {
    header("Location: ../../account/login.php");
}
if (!$user['admin']) {
    header("Location: ../../account/login.php");
}
if (!isset($_GET['id1'], $_GET['id2'], $_GET['id3'])) {
    //header("Location: competitionList.php");
}

$sb1 = generateScoreboard($_GET['id1']);
$sb2 = generateScoreboard($_GET['id2']);
$sb3 = generateScoreboardQuiz($_GET['id3']);

$totalSB = array();

foreach ($sb1 as $team => $points) {
    $totalSB[$team] += $points;
}

foreach ($sb2 as $team => $points) {
    $totalSB[$team] += $points;
}

foreach ($sb3 as $team => $points) {
    $totalSB[$team] += $points;
}

asort($totalSB);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Competition - <? echo $competition['competition_name'] ?></title>


    <link rel="stylesheet" href="../../../css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/site.css">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.2.0/styles/default.min.css">

    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="../../../js/bootstrap.min.js"></script>

    <script src="http://159.203.168.143:8080/socket.io/socket.io.js"></script>

    <? echo $gaCode; ?>
</head>

<body>

<div class="container-fluid">

    <? require_once "../../content/menu.php"; ?>

    <div class="bg-container">
        <div class="row">
            <div class="container">

                <div class="row">
                    <div class="col-md-12">
                        <h2>Final Scores</h2>
                    </div>
                </div>

                <!-- PAGE CONTENT HERE -->
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-bordered">
                            <tr>
                                <th>Team Name</th>
                                <th>Speed Round</th>
                                <th>AP Round</th>
                                <th>MCQ Round</th>
                                <th>Total</th>
                            </tr>

                            <?

                            foreach ($totalSB as $team => $totalPoints) {
                                ?>
                                <tr>
                                    <td><? echo $team; ?></td>
                                    <td><? echo $sb1[$team]; ?></td>
                                    <td><? echo $sb2[$team]; ?></td>
                                    <td><? echo $sb3[$team]; ?></td>
                                    <td><? echo $totalPoints; ?></td>
                                </tr>
                                <?
                            }

                            ?>
                        </table>
                    </div>
                </div>

            </div>
        </div>


    </div>
</body>
</html>
