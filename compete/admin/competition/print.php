<?php
require_once "../../content/require.php";

if (!isUserLoggedIn()) {
    header("Location: ../../account/login.php");
}
if (!$user['admin']) {
    header("Location: ../../account/login.php");
}

if (!isset($_GET['id'])) {
    header("Location: competitionList.php");
}

$state = $db->prepare("select pd.* from problem_data pd inner join competition_section_problems csp on csp.problem_id = pd.id where csp.section_id = ?");
$state->execute(array($_GET['id']));

$problems = $state->fetchAll(PDO::FETCH_ASSOC);

$state = $db->prepare("select * from competition_sections where id = ?");
$state->execute(array($_GET['id']));
$section = $state->fetchAll(PDO::FETCH_ASSOC)[0];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Print Problems</title>


    <link rel="stylesheet" href="../../../css/bootstrap.min.css">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.2.0/styles/default.min.css">

    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="../../../js/bootstrap.min.js"></script>

    <? echo $gaCode; ?>
</head>

<body>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12" style="padding-top:2.5in;">
            <div class="text-center">
                <img src="../../../images/SunNFPC.png" style="width: 2.5in;"/>

                <h1>Naples Florida Programming Competition</h1>

                <h2><? echo $section['section_name']; ?></h2>
            </div>

            <? foreach ($problems as $problem) { ?>
                <span style="page-break-after: always;"></span>
                <h1 class="text-center"><? echo $problem['problem_title']; ?></h1>
                <? echo $problem['problem_description']; ?>
<!--                <span style="page-break-after: always;"></span>-->
                <div class="container">
                    <div class="row">
                        <div class="col-md-6">
                            <h2>SAMPLE INPUT: </h2>
                            <pre class="well well-sm"><? echo $problem['problem_sample_input']; ?></pre>
                        </div>
                        <div class="col-md-6">
                            <h2>SAMPLE OUTPUT: </h2>
                            <pre class="well well-sm"><? echo $problem['problem_sample_output']; ?></pre>
                        </div>
                    </div>
                </div>
                <span style="page-break-after: always;"></span>
            <? } ?>
        </div>
    </div>
</body>
</html>
