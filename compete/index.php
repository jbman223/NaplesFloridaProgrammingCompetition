<?php
require_once "content/require.php";

if (!isUserLoggedIn()) {
    header("Location: account/login.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>ProgrammingCompetition.org Competition Site</title>


    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="css/site.css">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">

    <script src="http://programmingcompetition.org/compete/jquery.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>

    <script src="http://ws.programmingcompetition.org:8080/socket.io/socket.io.js"></script>

    <? echo $gaCode; ?>
</head>

<body>

<div class="container-fluid">

    <? require_once "content/menu.php"; ?>

    <div class="bg-container">
        <div class="row">
            <div class="container">

                <div class="row">
                    <div class="col-md-12">
                        <!-- PAGE CONTENT HERE -->
                        <h1>Welcome, <? echo $user['team_name']; ?>!</h1>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4"><h2><a href="solve">Submit A Solution</a></h2></div>
                    <div class="col-md-4"><h2><a href="problems">Problem Listing</a></h2></div>
                    <div class="col-md-4"><h2><a href="forum">Clarifications</a></h2></div>
                </div>

                <div class="row">
                    <div class="col-md-4"><h2><a href="leaderboard">Leader Board</a></h2></div>
                    <div class="col-md-4"><h2><a href="references">References</a></h2></div>
                    <div class="col-md-4"><h2><a href="quiz">Quizzes</a></h2></div>
                </div>
            </div>
        </div>


    </div>

    <? require_once "content/footer.php"; ?>

    <script src="js/liveEvents.js"></script>
</body>
</html>