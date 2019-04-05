<?php
require_once "require.php";
if (!isLoggedIn()) {
    header("Location: " . $_SERVER['HTTP_REFERER']);
    die();
}

if (!isset($_GET['id'])) {
    header("Location: " . $_SERVER['HTTP_REFERER']);
    die();
}
$state = $db->prepare("SELECT field_value FROM admin_current_competition WHERE field_name = ?");
$state->execute(array("competition_id"));
$id = $state->fetchAll()[0][0];
if ($id === "" && !isAdmin()) {
    header("Location: " . $_SERVER['HTTP_REFERER']);
    die();
}

$id = intval($id);

$state = $db->prepare("SELECT * FROM problems WHERE id = ?");
$state->execute(array($_GET['id']));
$problem = $state->fetchAll();

if (count($problem) != 1) {
    header("Location: " . $_SERVER['HTTP_REFERER']);
    die();
}

$problem = $problem[0];
if ($problem['competition_id'] != $id && !isAdmin()) {
    header("Location: " . $_SERVER['HTTP_REFERER']);
    die();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="The official Naples Florida Programming Competition.">
    <meta name="author" content="Jacob Buckheit">
    <link rel="icon" href="../../../../favicon.ico">

    <title>NFPC Competition Manager</title>

    <link href="/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="/jb.css" rel="stylesheet">

    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <![endif]-->
</head>

<body>
<div class="container">
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <?
            $state = $db->prepare("SELECT * FROM solved_problems WHERE team_id = ? AND competition_id = ? AND problem_id = ?");
            $state->execute(array($_SESSION['team_id'], $problem['competition_id'], $problem['id']));
            $solved = $state->fetchAll();
            if (count($solved) != 0) {
                ?>
                <div class="alert alert-success">
                    You have already solved this problem! :)
                </div>
            <?
            }
            ?>
            <h1><? echo $problem['problem_title']; ?></h1>
            <br/>

            <p class="lead text-justify"><? echo nl2br(file_get_contents($problem['problem_description_file'])); ?>
            </p>
            <br>

            <p class="text-left">
                <strong>SAMPLE INPUT</strong><br>
            </p>
            <pre><? echo file_get_contents($problem['problem_sample_input_file']); ?></pre>

            <p class="text-left">
                <strong>SAMPLE OUTPUT</strong><br>
            </p>
            <pre><? echo file_get_contents($problem['problem_sample_output_file']); ?></pre>

        </div>
    </div>
</div>

<script src="http://programmingcompetition.org/competitionSite/jquery.min.js"></script>
<script src="/js/bootstrap.min.js"></script>
</body>
</html>
